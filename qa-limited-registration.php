<?php

	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../');
		exit;
	}

	class qa_limited_registration {

		function admin_form(&$qa_content)
		{
			$saved = false;

			if (qa_clicked('limited_registration_save_button'))
			{
				qa_opt('limited_registration_permit_email', (int)qa_post_text('limited_registration_permit_email_field'));
				qa_opt('limited_registration_permitted_emails', qa_post_text('limited_registration_permitted_emails_field'));

				$check_emails = $this->check_emails();

				$saved = true;
			}

			$check_emails = $this->check_emails();

			return array(
				'ok' => $saved ? 'Limited Registration settings saved' : null,

				'fields' => array(
					array(
						'label' => 'Limit registration based on email address',
						'type' => 'checkbox',
						'value' => (int)qa_opt('limited_registration_permit_email'),
						'tags' => 'NAME="limited_registration_permit_email_field"',
					),
					array(
						'label' => 'Permitted email addresses (comma-separated):',
						'value' => qa_opt('limited_registration_permitted_emails'),
						'tags' => 'NAME="limited_registration_permitted_emails_field"',
						'type' => 'textarea',
						'rows' => 10,
						'error' => "$check_emails",
					),
				),

				'buttons' => array(
					array(
						'label' => 'Save Changes',
						'tags' => 'NAME="limited_registration_save_button"',
					),
				),
			);
		}

		var $directory;

		function load_module($directory, $urltoroot)
		{
			$this->directory = $directory;
		}

		function check_emails()
		{
			$emails = preg_split('/[\ \n\,]+/', qa_opt('limited_registration_permitted_emails'));

			$check_emails = '<font color="green">All emails are valid.</font>';
			foreach ($emails as $email)
			{
				$validation = filter_var($email, FILTER_VALIDATE_EMAIL);
				if ($validation == FALSE)
				{
					$check_emails = 'Invalid email: '.$email;
					break;
				}
			}

			return $check_emails;
		}

		function filter_email(&$email, $olduser)
		{
			$permit_email = qa_opt('limited_registration_permit_email');
			if (empty($olduser) && $permit_email)
			{
				$permitted_email_values = qa_opt('limited_registration_permitted_emails');
				if (isset($permitted_email_values))
				{
					$permitted_emails = preg_split('/[\ \n\,]+/', $permitted_email_values);

					$permit = FALSE;
					foreach ($permitted_emails as $permitted_email)
					{
						if (strcasecmp(trim($permitted_email), trim($email)) == 0)
						{
							$permit = TRUE;
							break;
						}
					}
					if (!$permit)
					{
						return 'Email is not allowed';
					}
				}
			}
			return NULL;
		}
	}
/*
	Omit PHP closing tag to help avoid accidental output
*/
