<?php

declare(strict_types=1);

namespace app\common\library;

use Shopify\Auth\Session;
use Shopify\Auth\SessionStorage;

final class MockSessionStorage implements SessionStorage
{
    /** @var array */
    private $mockSessions = [];
    /** @var array */
    private $calls = [];
    /** @var array */
    private $scheduledFails = [
        'store' => 0,
        'load' => 0,
        'delete' => 0,
    ];

    public function storeSession(Session $session): bool
    {
        $shouldSucceed = $this->shouldCallSucceed('store');

        $this->calls[] = ['store', $session];

        if ($shouldSucceed) {
            $this->mockSessions[$session->getId()] = $session;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return Session|null
     */
    public function loadSession(string $sessionId)
    {
        $shouldSucceed = $this->shouldCallSucceed('load');
        echo "shouldSucceed:".$shouldSucceed;
        echo "mockSessions:".json_encode($this->mockSessions);
        $this->calls[] = ['load', $sessionId];

        if ($shouldSucceed) {
            return $this->mockSessions[$sessionId] ?? null;
        } else {
            return null;
        }
    }

    public function deleteSession(string $sessionId): bool
    {
        $shouldSucceed = $this->shouldCallSucceed('delete');

        $this->calls[] = ['delete', $sessionId];

        if ($shouldSucceed) {
            unset($this->mockSessions[$sessionId]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retrieves the calls made to this class for assertions.
     *
     * @return array
     */
    public function getCalls(): array
    {
        return $this->calls;
    }

    /**
     * Tells this object that the next $amount calls to $method will fail.
     *
     * @param string $method The method to fail
     * @param int    $amount How many calls will fail
     */
    public function failNextCalls(string $method, int $amount = 1): void
    {
        $this->scheduledFails[$method] = $amount;
    }

    /**
     * Determines whether the current call for $method should fail.
     *
     * @param string $method The method to check
     *
     * @return bool
     */
    private function shouldCallSucceed(string $method): bool
    {
        if ($this->scheduledFails[$method]) {
            $this->scheduledFails[$method]--;
            return false;
        }

        return true;
    }
}
