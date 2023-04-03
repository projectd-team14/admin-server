<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;

final class Firewall
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next)
    {
        if (env('APP_ENV') === 'local' || $this->isAllowedIp($request->ip())) {
            return $next($request);
        }

        throw new AuthorizationException(sprintf('Access denied from %s', $request->ip()));
    }

    /**
     * @param string $ip
     * @return bool
     */
    private function isAllowedIp(string $ip): bool
    {
        $adminIpList = explode(",", env('ADMIN_IP'));

        $globalIp = file_get_contents('http://httpbin.org/ip');

        $jsonIp = json_decode($globalIp, true);
        $ipList = explode('.', $jsonIp['origin']);
        $ipAll = $ipList[0] . '.' . $ipList[1] . '.' . $ipList[2];

        return in_array($ipAll, $adminIpList);
    }
}
