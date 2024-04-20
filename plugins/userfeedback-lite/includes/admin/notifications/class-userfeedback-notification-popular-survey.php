<?php

/**
 * Popular Survey Notification class.
 *
 * Notification shown when a survey reaches a certain amount of responses
 *
 * @see UserFeedback_Notification_Event
 * @since 1.0.0
 *
 * @package UserFeedback
 * @subpackage Notifications
 * @author  David Paternina
 */
class UserFeedback_Notification_Popular_Survey extends UserFeedback_Notification_Event {

	public $id            = 'userfeedback_popular_survey';
	public $license_types = array( 'lite', 'plus', 'pro' );

	public function prepare() {
		$query = UserFeedback_Response::query();
		$query->select( array( 'survey_id', 'count' ) )
			->group_by( 'survey_id' )
			->sort( 'count', 'desc' );
		$largest_survey_count = $query->single();
		$survey = (new UserFeedback_Survey)->find($largest_survey_count->survey_id);
		if ( empty( $largest_survey_count ) || $largest_survey_count->count < 25 || is_null($survey) ) {
			// Shouldn't show, bail
			return null;
		}
		
		if(isset($survey->title)){
			$this->title   = sprintf(
				__( 'Wow! Your %s is Popular!', 'userfeedback' ),
				$survey->title
			);
			$this->content = sprintf(
				__( 'Your Survey, %s is popular! See what your visitors are saying', 'userfeedback' ),
				$survey->title
			);
	
			$this->buttons[] = array(
				'text' => __( 'See Responses', 'userfeedback' ),
				'url'  => userfeedback_get_screen_url(
					'userfeedback_results',
					"survey/{$largest_survey_count->survey_id}/responses"
				),
			);
	
			return parent::prepare();
		}

		return null;
	}

}

new UserFeedback_Notification_Popular_Survey();
