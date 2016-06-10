/*
 * This file is part of the MediaWiki extension UploadWizard.
 *
 * UploadWizard is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * UploadWizard is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with UploadWizard.  If not, see <http://www.gnu.org/licenses/>.
 */

( function ( mw, uw ) {
	/**
	 * @class uw.EventFlowLogger
	 * Event logging helper for funnel analysis. Should be instantiated at the very beginning; uses internal state
	 * to link events together.
	 * @constructor
	 * @param eventLog mw.eventLog object, for dependency injection
	 */
	uw.EventFlowLogger = function UWEventFlowLogger( eventLog ) {
		this.eventLog = eventLog;
	};

	/**
	 * Returns a string identifying this upload session for analytics purposes.
	 * Since UploadWizard is currently implemented as a single-page application, this is just
	 * a number regenerated on every pageview. It's stored as a string to avoid overflow problems
	 * on the backend.
	 * @private
	 * @return {string}
	 */
	uw.EventFlowLogger.prototype.getFlowId = function () {
		var rnd;

		if ( !uw.EventFlowLogger.flowId ) {
			rnd = '00' + Math.floor( Math.random() * 1000 );
			uw.EventFlowLogger.flowId = new Date().getTime() + rnd.substr( rnd.length - 3, 3 );
		}
		return uw.EventFlowLogger.flowId;
	};

	/**
	 * Returns a number identifying this event's position in the event flow.
	 * (I.e. (flowId, flowPosition) will uniquely identify an event, with the positions for a given
	 * flowId going 1..N.)
	 * @private
	 * @return {number}
	 */
	uw.EventFlowLogger.prototype.getFlowPosition = function () {
		uw.EventFlowLogger.flowPosition = ( uw.EventFlowLogger.flowPosition || 0 ) + 1;
		return uw.EventFlowLogger.flowPosition;
	};

	/**
	 * Does the work of logging a step.
	 * @private
	 * @param {'tutorial'|'file'|'deeds'|'details'|'thanks'} step
	 * @param {boolean} [skipped=false]
	 * @param {Object} [extraData] Extra data passed to the log.
	 */
	uw.EventFlowLogger.prototype.performStepLog = function ( step, skipped, extraData ) {
		var data = extraData || {};

		data.step = step;

		if ( skipped === true ) {
			data.skipped = true;
		}

		this.log( 'UploadWizardStep', data );
	};

	/**
	 * @protected
	 * Logs arbitrary data. This is for internal use, you should call one of the more specific functions.
	 * @param {string} schema EventLogger schema name
	 * @param {object} data event data (without flowId)
	 */
	uw.EventFlowLogger.prototype.log = function ( schema, data ) {
		if ( !this.eventLog ) {
			return;
		}
		data.flowId = this.getFlowId();
		data.flowPosition = this.getFlowPosition();
		this.eventLog.logEvent( schema, data );
	};

	/**
	 * Logs entering into a given step of the upload process.
	 * @param {'tutorial'|'file'|'deeds'|'details'|'thanks'} step
	 * @param {Object} [extraData] Extra data to pass along in the log.
	 */
	uw.EventFlowLogger.prototype.logStep = function ( step, extraData ) {
		this.performStepLog( step, false, extraData );
	};

	/**
	 * Logs skipping a given step of the upload process.
	 * @param {'tutorial'|'file'|'deeds'|'details'|'thanks'} step
	 */
	uw.EventFlowLogger.prototype.logSkippedStep = function ( step ) {
		this.performStepLog( step, true );
	};

	/**
	 * Logs an event.
	 * @param {string} name Event name. Recognized names:
	 *  - upload-button-clicked
	 *  - flickr-upload-button-clicked
	 *  - retry-uploads-button-clicked
	 *  - continue-clicked
	 *  - continue-anyway-clicked
	 *  - leave-page
	 */
	uw.EventFlowLogger.prototype.logEvent = function ( name ) {
		this.log( 'UploadWizardFlowEvent', { event: name } );
	};

	uw.EventFlowLogger.prototype.logError = function ( step, data ) {
		this.log( 'UploadWizardErrorFlowEvent', {
			step: step,
			code: data.code,
			message: String(data.message) // could be a function which kills EventLogging
		} );
	};

	/**
	 * Sets up logging for global javascript errors.
	 */
	uw.EventFlowLogger.prototype.installExceptionLogger = function () {
		function toNumber( val ) {
			var num = parseInt( val, 10 );
			if ( isNaN( num ) ) {
				return undefined;
			}
			return num;
		}

		var self = this;

		mw.trackSubscribe( 'global.error', function ( topic, data ) {
			self.log( 'UploadWizardExceptionFlowEvent', {
				message: data.errorMessage,
				url: data.url,
				line: toNumber( data.lineNumber ),
				column: toNumber( data.columnNumber ),
				stack: undefined // T91347
			} );
		} );
	};

	/**
	 * Logs an upload event.
	 * @param {string} name Event name. Recognized names:
	 *  - upload-started
	 *  - upload-succeeded
	 *  - upload-failed
	 *  - upload-removed
	 *  - uploads-added
	 * @param {object} data
	 * @param {string} data.extension file extension
	 * @param {number} data.quantity number of files added
	 * @param {number} data.size file size in bytes (will be anonymized)
	 * @param {number} data.duration upload duration in seconds
	 * @param {string} data.error upload error string
	 */
	uw.EventFlowLogger.prototype.logUploadEvent = function ( name, data ) {
		data.event = name;

		if ( 'size' in data ) {
			// anonymize size by rounding to closest number with 1 significant digit
			data.size = parseFloat( Number( data.size ).toPrecision( 1 ), 10 );
		}

		this.log( 'UploadWizardUploadFlowEvent', data );
	};

	// FIXME
	uw.eventFlowLogger = new uw.EventFlowLogger( mw.eventLog );
	uw.eventFlowLogger.installExceptionLogger();
}( mediaWiki, mediaWiki.uploadWizard ) );
