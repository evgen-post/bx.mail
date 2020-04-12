<?php
namespace Bx\Mail;

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Config\Option;

/**
 * Class Option
 * @package Bx\Mail
 */
class MailOption
{
    const MODULE_ID = 'bx.mail';
    const AUDIT_TYPE_ID = 'PHP Sender';

    const OPTION_ACTIVE = 'SMTP_ACTIVE';
    const OPTION_HOST = 'SMTP_HOST';
    const OPTION_USERNAME = 'SMTP_USERNAME';
    const OPTION_PASSWORD = 'SMTP_PASSWORD';
    const OPTION_PORT = 'SMTP_PORT';
    const OPTION_SENDER = 'SMTP_SENDER';
    const OPTION_ALLOW_SENDERS = 'MAIL_SENDERS';
    const OPTION_MAIL_SENDERS_STRICT = 'MAIL_SENDERS_STRICT';

    const DEFAULT_HOST = '';
    const DEFAULT_PORT = 587;
    const DEFAULT_USERNAME = '';
    const DEFAULT_PASSWORD = '';

    protected static $tabs = [
        [
            "DIV" => "MAIL",
            "TAB" => "Настройки и ограничения",
            "ICON" => "main_settings",
            "TITLE" => "Настройки и ограничения почтовых отправлений",
            'rows' => [
                [
                    'type' => 'header',
                    'label' => 'Настройка отправки почты',
                ],
                [
                    'label' => 'Использовать отправителя по умолчанию для всех писем',
                    'type' => 'checkbox',
                    'code' => 'SMTP_SENDER_ACTIVE',
                    'default' => 'N',
                    'values' => [
                        'N','Y',
                    ],
                ],
                [
                    'label' => 'Отправитель по умолчанию для всех писем',
                    'code' => 'SMTP_SENDER',
                    'attrs' => 'size="80"',
                ],
                [
                    'type' => 'header',
                    'label' => 'Блокировка отправки почты',
                ],
                [
                    'label' => 'Полностью заблокировать отправку почты',
                    'type' => 'checkbox',
                    'code' => 'BLOCKING_ALL_MAILS',
                    'default' => 'N',
                    'values' => [
                        'N','Y',
                    ],
                ],
                [
                    'type' => 'info',
                    'label' => '<span class="required">Будьте осторожны!</span> Данная установка полностью блокирует отправку почты.',
                ],
                [
                    'type' => 'header',
                    'label' => 'Изменение получателя для всех писем',
                ],
                [
                    'label' => 'Включить отправку всех писем на указанную почту',
                    'type' => 'checkbox',
                    'code' => 'MAIL_TO_ACTIVE',
                    'default' => 'N',
                    'values' => [
                        'N','Y',
                    ],
                ],
                [
                    'label' => 'Отправлять все письма только на указанную почту',
                    'type' => 'text',
                    'code' => 'MAIL_TO_EXACT',
                    'attrs' => 'size="80"',
                ],
                [
                    'type' => 'info',
                    'label' => '<span class="required">Будьте осторожны!</span> Если активировать данную настройку, то все письма будут отправляться только на указанную почту, вместо реального адресата. Реальный адресат письмо не получит.',
                ],
                [
                    'type' => 'header',
                    'label' => 'Органичения списка получателей',
                ],
                [
                    'label' => 'Включить ограничения для списка получателей',
                    'type' => 'checkbox',
                    'code' => 'MAIL_SENDERS_ACTIVE',
                    'default' => 'N',
                    'values' => [
                        'N','Y',
                    ],
                ],
                [
                    'label' => 'Разрешённые получатели',
                    'code' => 'MAIL_SENDERS',
                    'type' => 'textarea',
                    'attrs' => 'cols="80" rows="20"',
                ],
                [
                    'type' => 'info',
                    'label' => '<span class="required">Будьте осторожны!</span> Если активировать данную настройку, то все письма будут отправляться только на адреса, указанные в списке разрешённых получателей. Все остальные отправления будут заблокированы.',
                ],
            ],
        ],
        [
            "DIV" => "SMTP",
            "TAB" => "Настройки SMTP",
            "ICON" => "main_settings",
            "TITLE" => "Настройки SMTP",
            'rows' => [
                [
                    'type' => 'header',
                    'label' => 'Активность SMTP',
                ],
                [
                    'label' => 'Активность отправки SMTP',
                    'code' => 'SMTP_ACTIVE',
                    'default' => 'N',
                    'type' => 'checkbox',
                    'values' => [
                        'N','Y',
                    ],
                ],
                [
                    'type' => 'header',
                    'label' => 'Настройки SMTP',
                ],
                [
                    'label' => 'Хост',
                    'code' => 'SMTP_HOST',
                    'default' => MailOption::DEFAULT_HOST,
                    'attrs' => 'size="80"',
                ],
                [
                    'label' => 'Порт',
                    'code' => 'SMTP_PORT',
                    'default' => MailOption::DEFAULT_PORT,
                    'attrs' => 'size="80"',
                ],
                [
                    'label' => 'Логин',
                    'code' => 'SMTP_USERNAME',
                    'attrs' => 'size="80"',
                ],
                [
                    'label' => 'Пароль',
                    'code' => 'SMTP_PASSWORD',
                    'type' => 'password',
                    'attrs' => 'size="80"',
                ],
            ],
        ],
        [
            "DIV" => "TEST",
            "TAB" => "Проверка",
            "ICON" => "main_settings",
            "TITLE" => "Проверка",
            'rows' => [
                [
                    'type' => 'header',
                    'label' => 'Настройки SMTP',
                ],
            ],
        ],
        [
            "DIV" => "LOGS",
            "TAB" => "Лорирование",
            "ICON" => "main_settings",
            "TITLE" => "Логирование",
            'rows' => [
                [
                    'type' => 'header',
                    'label' => 'Настройки SMTP',
                ],
            ],
        ],
    ];

    const OPTION_FIELDS = [
        self::OPTION_ACTIVE,
        self::OPTION_HOST,
        self::OPTION_PORT,
        self::OPTION_USERNAME,
        self::OPTION_PASSWORD,
        self::OPTION_SENDER,
        self::OPTION_ALLOW_SENDERS,
        self::OPTION_MAIL_SENDERS_STRICT,
    ];

    protected $active;
    protected $host;
    protected $userName;
    protected $password;
    protected $port;
    protected $sender;
    protected $isStrict;
    protected $allowedEmails;

    /**
     *
     */
    public static function installModule()
    {
        $prologBeforeFile = __DIR__.'/../../../../bitrix/modules/main/include/prolog_before.php';
        if (file_exists($prologBeforeFile)) {
            include_once __DIR__.'/../../../../bitrix/modules/main/include/prolog_before.php';
            CustomMailAdapter::getInstance()->getLogger()->log('done');
        } else {
            CustomMailAdapter::getInstance()->getLogger()->log('no file');
        }
    }
    /**
     * @throws ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentNullException
     */
    public function getAllowedEmails()
    {
        if ($this->isStrict()) {
            if (is_null($this->allowedEmails)) {
                $this->allowedEmails = array_map('trim', preg_split("([\n,;]+)ui", Option::get(MailOption::MODULE_ID, MailOption::OPTION_ALLOW_SENDERS)));
            }
            return $this->allowedEmails;
        }
        return [];
    }
    /**
     * @param $fields
     * @throws ArgumentOutOfRangeException
     */
    public static function saveOptions($fields)
    {
        foreach (self::OPTION_FIELDS as $fieldName) {
            if (array_key_exists($fieldName, $fields)) {
                Option::set(self::MODULE_ID, $fieldName, $fields[$fieldName]);
            }
        }
    }

    /**
     * @return bool
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public function isActive()
    {
        if (!isset($this->active)) {
            $this->active = Option::get(self::MODULE_ID, self::OPTION_ACTIVE, 'N') === 'Y';
        }
        return $this->active;
    }

    /**
     * @param bool $active
     * @return MailOption
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return mixed
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public function getHost()
    {
        if (!isset($this->host)) {
            $this->host = Option::get(self::MODULE_ID, self::OPTION_HOST, self::DEFAULT_HOST);
        }

        return $this->host;
    }


    /**
     * @param mixed $host
     * @return MailOption
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return mixed
     * @throws ArgumentOutOfRangeException
     * @throws ArgumentNullException
     */
    public function getSender()
    {
        if (!isset($this->sender)) {
            $this->sender = Option::get(self::MODULE_ID, self::OPTION_SENDER);
        }
        return $this->sender;
    }

    /**
     * @param mixed $sender
     * @return MailOption
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @return mixed
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public function getUserName()
    {
        if (!isset($this->userName)) {
            $this->userName = Option::get(self::MODULE_ID, self::OPTION_USERNAME, self::DEFAULT_USERNAME);
        }

        return $this->userName;
    }

    /**
     * @param mixed $userName
     * @return MailOption
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * @return mixed
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public function getPassword()
    {
        if (!isset($this->password)) {
            $this->password = Option::get(self::MODULE_ID, self::OPTION_PASSWORD, self::DEFAULT_PASSWORD);
        }

        return $this->password;
    }

    /**
     * @param mixed $password
     * @return MailOption
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public function getPort()
    {
        if (!isset($this->port)) {
            $this->port = Option::get(self::MODULE_ID, self::OPTION_PORT, self::DEFAULT_PORT);
        }

        return $this->port;
    }

    /**
     * @param mixed $port
     * @return MailOption
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return bool
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public function isStrict()
    {
        if (is_null($this->isStrict)) {
            $this->isStrict = (Option::get(MailOption::MODULE_ID, MailOption::OPTION_MAIL_SENDERS_STRICT, 'N') === 'Y');
        }

        return $this->isStrict;
    }

    /**
     * @param bool $isStrict
     * @return MailOption
     */
    public function setIsStrict($isStrict)
    {
        $this->isStrict = $isStrict;
        return $this;
    }

    /**
     * @return CustomMailAdapter
     */
    public function getAdapter()
    {
        return CustomMailAdapter::getInstance();
    }

    /**
     * @return array
     */
    public static function getTabs()
    {
        return self::$tabs;
    }

}