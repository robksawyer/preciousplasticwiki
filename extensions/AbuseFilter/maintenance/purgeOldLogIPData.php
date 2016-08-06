<?php

if ( getenv( 'MW_INSTALL_PATH' ) ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$IP = dirname( __FILE__ ) . '/../../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class PurgeOldLogIPData extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Purge old IP Address data from AbuseFilter logs";
		$this->setBatchSize( 200 );
	}

	public function execute() {
		global $wgAbuseFilterLogIPMaxAge;

		$this->output( "Purging old IP Address data from abuse_filter_log...\n" );
		$dbw = wfGetDB( DB_MASTER );
		$cutoffUnix = time() - $wgAbuseFilterLogIPMaxAge;

		$count = 0;
		do {
			$ids = $dbw->selectFieldValues(
				'abuse_filter_log',
				'afl_id',
				array(
					'afl_ip <> ""',
					"afl_timestamp < " . $dbw->addQuotes( $dbw->timestamp( $cutoffUnix ) )
				),
				__METHOD__,
				array( 'LIMIT' => $this->mBatchSize )
			);

			if ( $ids ) {
				$dbw->update(
					'abuse_filter_log',
					array( 'afl_ip' => '' ),
					array( 'afl_id' => $ids ),
					__METHOD__
				);
				$count += $dbw->affectedRows();
				$this->output( "$count\n" );

				wfWaitForSlaves();
			}
		} while ( count( $ids ) >= $this->mBatchSize );

		$this->output( "$count rows.\n" );

		$this->output( "Done.\n" );
	}

}

$maintClass = "PurgeOldLogIPData";
require_once( RUN_MAINTENANCE_IF_MAIN );
