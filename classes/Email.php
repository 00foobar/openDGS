<?php

class Email
{
	private $config;

	private $recipients = array();
	private $invalid_recipients = array();

	private $send_failures = array();

	private $subject;
	private $template;
	private $header = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\nFrom: admin@eduard-damm.de\r\nReply-To: admin@eduard-damm.de\r\n";

	public function __construct()
	{
		// $this->config = new Config();
	}

	/* Getter */
	public function getInvalidRecipients()
	{
		return $this->invalid_recipients;
	}

	public function getSendFailures()
	{
		return $this->send_failures;
	}

	/* Setter */
	public function setRecipients($recipients)
	{
		// an array of recipients
		if ( is_array($recipients) )
		{
			foreach ($recipients as $recipient)
			{
				if ( Validate::Email($recipient) )
				{
					$this->recipients[] = $recipient;
				}
				else
				{
					$this->invalid_recipients[] = $recipient;
				}
			}

			if ( count($this->recipients) > 0 )
			{
				return true;
			}

			return false;
		}
		elseif ( is_string($recipients) )
		{
			// a single recipient
			if ( Validate::Email($recipients) )
			{
				$this->recipients[] = $recipients;

				return true;
			}

			return false;
		}

		return false;
	}

	public function setSubject($subject)
	{
		if ( strlen($subject) < 256 )
		{
			$this->subject = strip_tags($subject);
			return true;
		}
		
		return false;
	}

	public function setTemplate($template)
	{
		$this->template = $template;

		return true;
	}

	public function setHeader($header)
	{
		$this->header = $header;

		return true;
	}

	/* Mail */
	public function sendMail()
	{
		if ( count($this->recipients) < 1 )
		{
			throw new Exception("Error: No recipient set.", 1);
		}

		if ( empty($this->subject) )
		{
			throw new Exception("Error: No subject set.", 1);
		}

		if ( empty($this->template) )
		{
			throw new Exception("Error: No template set.", 1);	
		}

		if ( empty($this->header) )
		{
			throw new Exception("Error: No headers set.", 1);
		}

		$success_count = 0;

		foreach ($this->recipients as $recipient)
		{
			if ( mail($recipient, $this->subject, $this->template, $this->header) )
			{
				$success_count = $success_count + 1;
			}
			else
			{
				$this->send_failures[] = $recipient;
			}
		}

		if ( $success_count == count($this->recipients) )
		{
			// full success
			return true;
		}
		elseif ( $success_count == 0 )
		{
			// full failure
			return false;
		}

		// partially failure/success
		return $this->send_failures;
	}
}
?>