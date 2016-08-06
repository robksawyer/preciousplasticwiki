<?php

class ApiAbuseFilterCheckMatch extends ApiBase {
	public function execute() {
		$params = $this->extractRequestParams();
		$this->requireOnlyOneParameter( $params, 'vars', 'rcid', 'logid' );

		// "Anti-DoS"
		if ( !$this->getUser()->isAllowed( 'abusefilter-modify' ) ) {
			$this->dieUsage( 'You don\'t have permission to test abuse filters', 'permissiondenied' );
		}

		$vars = null;
		if ( $params['vars'] ) {
			$vars = new AbuseFilterVariableHolder;
			$pairs = FormatJson::decode( $params['vars'], true );
			foreach ( $pairs as $name => $value ) {
				$vars->setVar( $name, $value );
			}
		} elseif ( $params['rcid'] ) {
			$dbr = wfGetDB( DB_SLAVE );
			$row = $dbr->selectRow(
				'recentchanges',
				'*',
				array( 'rc_id' => $params['rcid'] ),
				__METHOD__
			);

			if ( !$row ) {
				$this->dieUsageMsg( array( 'nosuchrcid', $params['rcid'] ) );
			}

			$vars = AbuseFilter::getVarsFromRCRow( $row );
		} elseif ( $params['logid'] ) {
			$dbr = wfGetDB( DB_SLAVE );
			$row = $dbr->selectRow(
				'abuse_filter_log',
				'*',
				array( 'afl_id' => $params['logid'] ),
				__METHOD__
			);

			if ( !$row ) {
				$this->dieUsage(
					"There is no abuselog entry with the id ``{$params['logid']}''",
					'nosuchlogid'
				);
			}

			$vars = AbuseFilter::loadVarDump( $row->afl_var_dump );
		}

		if ( AbuseFilter::checkSyntax( $params[ 'filter' ] ) !== true ) {
			$this->dieUsage( 'The filter has invalid syntax', 'badsyntax' );
		}

		$result = array(
			'result' => AbuseFilter::checkConditions( $params['filter'], $vars ),
		);
		if ( defined( 'ApiResult::META_CONTENT' ) ) {
			$result[ApiResult::META_BC_BOOLS][] = 'result';
		}

		$this->getResult()->addValue(
			null,
			$this->getModuleName(),
			$result
		);
	}

	public function getAllowedParams() {
		return array(
			'filter' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
			'vars' => null,
			'rcid' => array(
				ApiBase::PARAM_TYPE => 'integer'
			),
			'logid' => array(
				ApiBase::PARAM_TYPE => 'integer'
			),
		);
	}

	/**
	 * @deprecated since MediaWiki core 1.25
	 */
	public function getParamDescription() {
		return array(
			'filter' => 'The full filter text to check for a match',
			'vars' => 'JSON encoded array of variables to test against',
			'rcid' => 'Recent change ID to check against',
			'logid' => 'Abuse filter log ID to check against',
		);
	}

	/**
	 * @deprecated since MediaWiki core 1.25
	 */
	public function getDescription() {
		return array(
			'Check to see if an AbuseFilter matches a set of variables, edit'
			. 'or logged AbuseFilter event.',
			'vars, rcid or logid is required however only one may be used',
		);
	}

	public function getExamples() {
		return array(
			'api.php?action=abusefiltercheckmatch&filter=!("autoconfirmed"%20in%20user_groups)&rcid=15'
		);
	}

	/**
	 * @see ApiBase::getExamplesMessages()
	 */
	protected function getExamplesMessages() {
		return array(
			'action=abusefiltercheckmatch&filter=!("autoconfirmed"%20in%20user_groups)&rcid=15'
				=> 'apihelp-abusefiltercheckmatch-example-1',
		);
	}
}
