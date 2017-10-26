<?php declare (strict_types = 1);

use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

// require Composer's autoloader
$loader = require __DIR__ . '/../vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

class AppKernel extends Kernel
{

	use MicroKernelTrait;

	public function registerBundles()
	{
		$bundles = [
			new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
			new Symfony\Bundle\TwigBundle\TwigBundle(),
			new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
		];

		if ($this->getEnvironment() == 'dev') {
			$bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
		}

		return $bundles;
	}

	protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
	{
		$loader->load(__DIR__ . '/../config/config.yml');

		// configure WebProfilerBundle only if the bundle is enabled
		if (isset($this->bundles['WebProfilerBundle'])) {
			$c->loadFromExtension('web_profiler', array(
				'toolbar' => true,
				'intercept_redirects' => false,
			));
		}
	}

	public function getCacheDir()
	{
		return __DIR__ . '/../var/cache';
	}

	public function getLogDir()
	{
		return __DIR__ . '/../var/log';
	}

	protected function configureRoutes(RouteCollectionBuilder $routes)
	{
		// import the WebProfilerRoutes, only if the bundle is enabled
		if (isset($this->bundles['WebProfilerBundle'])) {
			$routes->import('@WebProfilerBundle/Resources/config/routing/wdt.xml', '/_wdt');
			$routes->import('@WebProfilerBundle/Resources/config/routing/profiler.xml', '/_profiler');
		}

		// load the annotation routes
		$routes->import(__DIR__ . '/../src/App/Controller/', '/', 'annotation');
	}

}