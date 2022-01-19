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
 * @property bool $admin
 * @property string $status
 * @property bool $onboarded
 * @property array|null $settings
 * @property array|null $notifications
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $created
 */
class User extends Entity implements AuthenticationIdentity, AuthorizationIdentity
{
    public const CONTROLER_PREFIX = [
        'EETN',
        'EETT',
    ];

    public const STATUS_ACTIVE = 'active';
    public const STATUS_BLOCKED = 'blocked';

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => false,
    ];

    protected function _getSettings($settings)
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

    protected function _getNotifications($notifications)
    {
        if (empty($notifications)) {
            return [
                'eetn' => true,
            ];
        }

        return $notifications;
    }

    /**
     * Authorization\IdentityInterface method
     */
    public function getIdentifier(): int
    {
        return $this->get('id');
    }

    /**
     * Authorization\IdentityInterface method
     */
    public function can($action, $resource): bool
    {
        if (!$this->authorization) {
            throw new RuntimeException('Cannot check authorization. AuthorizationService has not been set.');
        }

        return $this->authorization->can($this, $action, $resource);
    }

    /**
     * Authorization\IdentityInterface method
     */
    public function canResult($action, $resource): ResultInterface
    {
        if (!$this->authorization) {
            throw new RuntimeException('Cannot check authorization. AuthorizationService has not been set.');
        }

        return $this->authorization->canResult($this, $action, $resource);
    }

    /**
     * Authorization\IdentityInterface method
     */
    public function applyScope($action, $resource)
    {
        if (!$this->authorization) {
            throw new RuntimeException('Cannot check authorization. AuthorizationService has not been set.');
        }

        return $this->authorization->applyScope($this, $action, $resource);
    }

    /**
     * Authorization\IdentityInterface method
     */
    public function getOriginalData()
    {
        return $this;
    }

    /**
     * Setter to be used by the middleware.
     */
    public function setAuthorization(AuthorizationServiceInterface $service)
    {
        $this->authorization = $service;

        return $this;
    }
}
