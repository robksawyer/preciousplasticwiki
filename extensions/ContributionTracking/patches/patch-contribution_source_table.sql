-- DO NOT run this script automatically, please babysit the deployment.

-- TODO: more better table name?
create table contribution_source (
    contribution_tracking_id int check (contribution_tracking_id > 0) not null,
    banner varchar(128),
    landing_page varchar(128),
    payment_method varchar(128),
    primary key (contribution_tracking_id)
);

create index banner on contribution_source (banner);
create index landing_page on contribution_source (landing_page);
create index payment_method on contribution_source (payment_method);

-- Backfill existing rows.
replace into contribution_source
select
    ct.id as contribution_tracking_id,
    substring_index(ct.utm_source, '.', 1) as banner,
    substring_index(substring_index(ct.utm_source, '.', 2), '.', -1) as landing_page,
    substring_index(ct.utm_source, '.', -1) as payment_method
from contribution_tracking ct
where
    (ct.utm_source is not null
        and (length(ct.utm_source) - length(replace(ct.utm_source, '.', ''))) = 2
    )
;

-- Create triggers to synchronize changes to the new table.
drop trigger if exists contribution_tracking_insert;
drop trigger if exists contribution_tracking_update;
delimiter //

create trigger contribution_tracking_insert
after insert
on contribution_tracking
for each row
begin
    -- Ensure that the utm_source has exactly two dots.
    if (new.utm_source is not null
        and (length(new.utm_source) - length(replace(new.utm_source, '.', ''))) = 2
    ) then
        -- Split column into its components.
        replace into contribution_source
            contribution_tracking_id := last_insert_id(),
            banner := substring_index(new.utm_source, '.', 1),
            landing_page := substring_index(substring_index(new.utm_source, '.', 2), '.', -1),
            payment_method := substring_index(new.utm_source, '.', -1);
    end if;
end;
//

create trigger contribution_tracking_update
after update
on contribution_tracking
for each row
begin
    -- Ensure that the utm_source has exactly two dots.
    if (new.utm_source is not null
        and (length(new.utm_source) - length(replace(new.utm_source, '.', ''))) = 2
    ) then
        -- Split column into its components.
        replace into contribution_source
            contribution_tracking_id := new.id,
            banner := substring_index(new.utm_source, '.', 1),
            landing_page := substring_index(substring_index(new.utm_source, '.', 2), '.', -1),
            payment_method := substring_index(new.utm_source, '.', -1);
    end if;
end;
//

-- Note there is no delete on contribution_tracking, hence no third trigger.

delimiter ;

-- CAREFULLY backfill again.  Run this statement manually
-- and verify that we aren’t locking the contribution
-- tracking table, after a few seconds.  Abort if so.
-- Run in limited batches until the coast is clear.
insert ignore into contribution_source
select
    ct.id as contribution_tracking_id,
    substring_index(ct.utm_source, '.', 1) as banner,
    substring_index(substring_index(ct.utm_source, '.', 2), '.', -1) as landing_page,
    substring_index(ct.utm_source, '.', -1) as payment_method
from contribution_tracking ct
left join contribution_source cs
    on ct.id = cs.contribution_tracking_id
where
    cs.contribution_tracking_id is null
    and (ct.utm_source is not null
        and (length(ct.utm_source) - length(replace(ct.utm_source, '.', ''))) = 2
    )
limit 1000
;
