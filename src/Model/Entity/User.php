<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\IdentityInterface as AuthenticationIdentity;
use Authorization\AuthorizationServiceInterface;
use Authorization\IdentityInterface as AuthorizationIdentity;
use Authorization\Policy\ResultInterface;
use Cake\ORM\Entity;
use RuntimeException;

/**
 * User Entity
 *
 * @property string $id
 * @property string $vatsim_id
 * @property string $full_name
 * @property string $role
 * @property string $status
 * @property array|null $settings
 * @property array|null $notifications
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $created
 */
class User extends Entity implements AuthenticationIdentity, AuthorizationIdentity
{
    /**
     * @var array<int, string>
     */
    public const CONTROLER_PREFIX = [
        'LOVV',
        'LOWW',
    ];

    /**
     * @var string
     */
    public const STATUS_ACTIVE = 'active';

    /**
     * @var string
     */
    public const STATUS_BLOCKED = 'blocked';

    /**
     * @var string
     */
    public const ROLE_USER = 'user';

    /**
     * @var string
     */
    public const ROLE_ADMIN = 'admin';

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        '*' => false,
    ];

    /**
     * @var \Authorization\AuthorizationServiceInterface|null
     */
    protected $authorization = null;

    /**
     * @param array $settings Settings
     * @return array
     */
    protected function _getSettings($settings): array
    {
        if (empty($settings)) {
            return [
                'notifications' => true,
                'sounds' => true,
                'volume' => 0.5,
            ];
        }

        return $settings;
    }

    /**
     * @param array $notifications Notifications
     * @return array
     */
    protected function _getNotifications(array $notifications): array
    {
        if (empty($notifications)) {
            return [
                'loww' => true,
            ];
        }

        return $notifications;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->get('id');
    }

    /**
     * @param string $action The action/operation being performed.
     * @param mixed $resource The resource being operated on.
     * @return bool
     */
    public function can($action, $resource): bool
    {
        if (!$this->authorization) {
            throw new RuntimeException('Cannot check authorization. AuthorizationService has not been set.');
        }

        return $this->authorization->can($this, $action, $resource);
    }

    /**
     * @param string $action The action/operation being performed.
     * @param mixed $resource The resource being operated on.
     * @return \Authorization\Policy\ResultInterface
     */
    public function canResult(string $action, $resource): ResultInterface
    {
        if (!$this->authorization) {
            throw new RuntimeException('Cannot check authorization. AuthorizationService has not been set.');
        }

        return $this->authorization->canResult($this, $action, $resource);
    }

    /**
     * @param string $action The action/operation being performed.
     * @param mixed $resource The resource being operated on.
     * @return mixed The modified resource.
     */
    public function applyScope(string $action, $resource)
    {
        if (!$this->authorization) {
            throw new RuntimeException('Cannot check authorization. AuthorizationService has not been set.');
        }

        return $this->authorization->applyScope($this, $action, $resource);
    }

    /**
     * @return \ArrayAccess|array
     */
    public function getOriginalData()
    {
        return $this;
    }

    /**
     * @param \Authorization\AuthorizationServiceInterface $service The authorization service.
     * @return $this
     */
    public function setAuthorization(AuthorizationServiceInterface $service)
    {
        $this->authorization = $service;

        return $this;
    }
}
