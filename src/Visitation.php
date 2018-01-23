<?php

use Dibi\Connection;
use Latte\Engine;
use Locale\ILocale;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Localization\ITranslator;
use Nette\Mail\IMailer;
use Nette\Mail\Message;


/**
 * Class Visitation
 *
 * @author  geniv
 */
class Visitation extends Control
{
    // define constant table names
    const
        TABLE_NAME = 'visitation';

    /** @var string table names */
    private $tableVisitation;
    /** @var Connection database connection from DI */
    private $connection;
    /** @var ILocale */
    private $locale;
    /** @var ITranslator */
    private $translator;

    /** @var Message */
    private $message;
    /** @var IMailer */
    private $mailer;

    /** @var string template path */
    private $templatePath, $templateEmailPath;
    /** @var callback method */
    public $onSuccess;


    /**
     * Visitation constructor.
     *
     * @param             $prefix
     * @param Connection  $connection
     * @param ILocale     $locale
     * @param ITranslator $translator
     * @param IMailer     $mailer
     */
    public function __construct($prefix, Connection $connection, ILocale $locale, ITranslator $translator, IMailer $mailer)
    {
        parent::__construct();

        // define table names
        $this->tableVisitation = $prefix . self::TABLE_NAME;

        $this->connection = $connection;
        $this->locale = $locale;
        $this->translator = $translator;

        $this->message = new Message;
        $this->mailer = $mailer;

        // default paths
        $this->templatePath = __DIR__ . '/Visitation.latte';
        $this->templateEmailPath = __DIR__ . '/VisitationEmail.latte';
    }


    /**
     * Set template path.
     *
     * @param string $path
     * @return $this
     */
    public function setTemplatePath($path)
    {
        $this->templatePath = $path;
        return $this;
    }


    /**
     * Set email template path.
     *
     * @param $path
     * @return $this
     */
    public function setTemplateEmailPath($path)
    {
        $this->templateEmailPath = $path;
        return $this;
    }


    /**
     * Email message.
     *
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * Form.
     *
     * @param $name
     * @return Form
     */
    protected function createComponentForm($name)
    {
        $form = new Form($this, $name);
        $form->setTranslator($this->translator);
        $form->addText('telemail', 'visitation-telemail')
            ->setRequired('visitation-telemail-required');

        $form->addSubmit('send', 'visitation-send');

        $form->onSuccess[] = function (Form $form, array $values) {
            $arr = [
                'id_locale' => $this->locale->getId(),
                'telemail'  => $values['telemail'],
                'added%sql' => 'NOW()',
                'ip'        => $_SERVER['REMOTE_ADDR'],
            ];

            $ret = $this->connection->insert($this->tableVisitation, $arr)->execute();
            if ($ret > 0) {
                $values['localeCode'] = $this->locale->getCode();
                $values['localeName'] = ($values['localeCode'] ? $this->locale->getListName()[$values['localeCode']] : null);
                $values['baseUri'] = $this->template->baseUri;

                $latte = new Engine;
                //TODO latte neobsahuje podporu pro linky a preklad
                $template = $latte->renderToString($this->templateEmailPath, $values);

                // message
                $this->message->setHtmlBody($template);

                // mailer
                $this->mailer->send($this->message);

                $this->onSuccess($values);
            }
        };
        return $form;
    }


    /**
     * Render default.
     */
    public function render()
    {
        $template = $this->getTemplate();

        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}
