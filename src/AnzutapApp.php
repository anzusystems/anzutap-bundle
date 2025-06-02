<?php

/** @noinspection PhpUnused */
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle;

use AnzuSystems\Contracts\Exception\AnzuException;
use DateTimeImmutable;
use DateTimeZone;
use RuntimeException;

class AnzutapApp
{
    public const string DATETIME_MIN = '1970-01-01 00:00:00';
    public const string DATETIME_MAX = '2100-01-01 00:00:00';
    public const int ZERO = 0;
    public const float FLOAT_ZERO = 0.0;
    public const string EMPTY_STRING = '';

    protected static DateTimeImmutable $appDate;
    private static string $projectDir = '';
    private static string $dataDir;
    private static string $downloadDir;
    private static string $appEnv;
    private static string $contextId = '';
    private static bool $initialized = false;
    private static string $appSystem;
    private static string $appVersion;

    /**
     * @var non-empty-string
     */
    private static string $appTimeZone;

    /**
     * Run at kernel boot.
     *
     * @param non-empty-string $appTimeZone
     */
    public static function init(
        string $appSystem,
        string $appVersion,
        string $appTimeZone,
        string $projectDir,
        string $appEnv,
        string $contextId = '',
    ): void {
        self::$appSystem = $appSystem;
        self::$appVersion = $appVersion;
        self::$appTimeZone = $appTimeZone;
        self::$initialized = true;
        self::$appDate = static::prepareAppDate();
        self::$appEnv = $appEnv;
        self::$projectDir = $projectDir;
        self::$dataDir = self::$projectDir . '/var/mnt/data';
        self::$downloadDir = self::$dataDir . '/download';
        self::$contextId = $contextId;
    }

    /**
     * Get context id from kernel or if wasn't set yet, generate a new context id.
     */
    public static function getContextId(): string
    {
        if ('' === self::$contextId) {
            self::$contextId = (string) uuid_create();
        }

        return self::$contextId;
    }

    public static function setContextId(string $contextId): void
    {
        self::$contextId = $contextId;
    }

    public static function getAppEnv(): string
    {
        self::throwExceptionOnNotInitialized();

        return self::$appEnv;
    }

    public static function getAppVersion(): string
    {
        self::throwExceptionOnNotInitialized();

        return self::$appVersion;
    }

    public static function getAppSystem(): string
    {
        self::throwExceptionOnNotInitialized();

        return self::$appSystem;
    }

    /**
     * @psalm-return non-empty-string
     */
    public static function getAppTimeZoneValue(): string
    {
        self::throwExceptionOnNotInitialized();

        return self::$appTimeZone;
    }

    public static function getAppTimeZone(): DateTimeZone
    {
        return new DateTimeZone(static::getAppTimeZoneValue());
    }

    public static function getAppVersionWithSystem(): string
    {
        return sprintf('%s-%s', self::getAppSystem(), self::getAppVersion());
    }

    /**
     * Get dateTime of application boot.
     */
    public static function getAppDate(): DateTimeImmutable
    {
        self::throwExceptionOnNotInitialized();

        return self::$appDate;
    }

    /**
     * Get dateTime of start of unix epoch.
     */
    public static function getMinDate(): DateTimeImmutable
    {
        return new DateTimeImmutable(self::DATETIME_MIN);
    }

    /**
     * Get maximum agreed dateTime.
     */
    public static function getMaxDate(): DateTimeImmutable
    {
        return new DateTimeImmutable(self::DATETIME_MAX);
    }

    public static function getProjectDir(): string
    {
        self::throwExceptionOnNotInitialized();

        return self::$projectDir;
    }

    public static function getDataDir(): string
    {
        return self::getDir(self::$dataDir);
    }

    public static function getDownloadDir(): string
    {
        return self::getDir(self::$downloadDir);
    }

    protected static function prepareAppDate(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }

    /**
     * @throws AnzuException
     */
    protected static function getDir(string $dir): string
    {
        self::throwExceptionOnNotInitialized();

        if (is_dir($dir)) {
            return $dir;
        }
        if (false === mkdir($dir, 0_777, true) && false === is_dir($dir)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }

        return $dir;
    }

    /**
     * @throws AnzuException
     */
    protected static function throwExceptionOnNotInitialized(): void
    {
        if (false === self::$initialized) {
            throw new AnzuException(sprintf(
                'Class "%s" needs to be initialized first.',
                self::class,
            ));
        }
    }
}
