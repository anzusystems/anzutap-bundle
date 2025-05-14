<?php

declare(strict_types=1);

namespace AnzuSystems\AnzuTapBundle\Kernel;

use AnzuSystems\AnzuTapBundle\AnzuTapApp;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Kernel;

class AnzuTapKernel extends Kernel
{
    use MicroKernelTrait;

    /**
     * If this header is sent, application context uses this identity rather than generating a new one.
     */
    public const string CONTEXT_IDENTITY_HEADER = 'X-Context-ID';

    /**
     * Load balancer IP is dynamic and can change anytime.
     * HAProxy is setting this header to each request and removes it on each response,
     * so we can trust it and append it to trusted proxies.
     */
    private const string LOAD_BALANCER_IP_HEADER = 'X-LoadBalancer-IP';

    private string $loadBalancerIp = '';
    private string $contextId = '';

    public function __construct(
        private readonly string $appSystem,
        private readonly string $appVersion,
        private readonly string $appTimeZone,
        string $environment,
        bool $debug,
    ) {
        parent::__construct(
            environment: $environment,
            debug: $debug
        );
    }

    /**
     * Override to set up static stuff at boot time.
     */
    public function boot(): void
    {
        $this->getAppClassFactory()(
            $this->appSystem,
            $this->appVersion,
            $this->appTimeZone,
            $this->getProjectDir(),
            $this->getEnvironment(),
            $this->contextId,
        );

        parent::boot();

        $trustedProxies = Request::getTrustedProxies();
        if ($this->loadBalancerIp && $trustedProxies) {
            $trustedProxies[] = $this->loadBalancerIp;
            /** @psalm-suppress ArgumentTypeCoercion */
            Request::setTrustedProxies($trustedProxies, Request::getTrustedHeaderSet());
        }
    }

    public function handle(
        Request $request,
        int $type = HttpKernelInterface::MAIN_REQUEST,
        bool $catch = true
    ): Response {
        $this->loadBalancerIp = (string) $request->headers->get(self::LOAD_BALANCER_IP_HEADER);
        $this->contextId = (string) $request->headers->get(self::CONTEXT_IDENTITY_HEADER);

        return parent::handle($request, $type, $catch);
    }

    /**
     * @return callable(string,string,string,string,string,string=):void
     */
    protected function getAppClassFactory(): callable
    {
        return AnzuTapApp::init(...);
    }
}
