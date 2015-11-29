<?php namespace Mrk\Mailgun;

use Mailgun\Mailgun;

class Mailer extends \Mailer
{
    private $mailgun;


    /**
     * Mailer constructor.
     */
    function __construct()
    {
        $this->mailgunKey = \Config::inst()->get('MailGun', 'key');
        $this->mailgunDomain = \Config::inst()->get('MailGun', 'domain');
        $this->mailgunFrom = \Config::inst()->get('MailGun', 'from');
        $this->mailgun = new Mailgun($this->mailgunKey);
    }


    /**
     * @param string $to
     * @param string $from
     * @param $subject
     * @param string $plainContent
     * @param array $attachedFiles
     * @param bool|false $customheaders
     * @return \stdClass
     * @throws \Mailgun\Messages\Exceptions\MissingRequiredMIMEParameters
     */
    public function sendPlain($to, $from, $subject, $plainContent, $attachedFiles = array(), $customheaders = false)
    {
        $message = array(
            'from' => $this->mailgunFrom,
            'to' => $to,
            'subject' => $subject,
            'text' => $plainContent
        );

        $message = $this->addCustomHeaders($message, $customheaders);


        return $this->mailgun
            ->sendMessage($this->mailgunDomain, $message, $attachedFiles);

    }


    /**
     * @param $to
     * @param $from
     * @param $subject
     * @param $htmlContent
     * @param array $attachedFiles
     * @param bool|false $customheaders
     * @param bool|false $plainContent
     * @return \stdClass
     * @throws \Mailgun\Messages\Exceptions\MissingRequiredMIMEParameters
     */
    public function sendHTML($to, $from, $subject, $htmlContent, $attachedFiles = array(), $customheaders = false,
                             $plainContent = false)
    {

        $message = array(
            'from' => $this->mailgunFrom,
            'to' => $to,
            'subject' => $subject,
            'html' => $htmlContent
        );

        if ($plainContent)
            $message['text'] = $plainContent;


        $message = $this->addCustomHeaders($message, $customheaders);


        return $this->mailgun
            ->sendMessage($this->mailgunDomain, $message, $attachedFiles);


    }


    /**
     * [addCustomHeaders description]
     * @param [type] $message [description]
     * @param [type] $headers [description]
     */
    private function addCustomHeaders($message, $headers)
    {
        unset($headers['X-SilverStripeSite']);

        if ($headers) {
            foreach ($headers as $key => $value) {
                $message[$key] = $value;
            }
        }

        return $message;

    }
}

?>