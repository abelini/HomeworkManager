<?php
declare(strict_types=1);

namespace App;

use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\Router;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\IdentifierInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Psr\Http\Message\ServerRequestInterface;


class Application extends BaseApplication implements AuthenticationServiceProviderInterface {
    /**
     * Load all the application configuration and bootstrap logic.
     *
     * @return void
     */
    public function bootstrap(): void {
        // Call parent to load bootstrap from files.
        parent::bootstrap();

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        } else {
            FactoryLocator::add(
                'Table',
                (new TableLocator())->allowFallbackClass(false)
            );
        }
		/*
		 * Only try to load DebugKit in development mode
		 * Debug Kit should not be installed on a production system
		 */
		if (Configure::read('debug')) {
			$this->addPlugin('DebugKit');
			Configure::write('DebugKit.forceEnable', true);
			Configure::write('DebugKit.variablesPanelMaxDepth', 8);
			//Configure::write('DebugKit.safeTld', ['https://uashistoriademexico.com']);
		}
		// Load more plugins here
		$this->addPlugin('Authentication');
		
		Configure::write('CakePdf', ['engine' => 'CakePdf.CustomWkHtmlToPdf',]);
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
	public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue {
	    
		$csrf = new CsrfProtectionMiddleware(['httponly' => true,]);

		// Token check will be skipped when callback returns `true`.
		$csrf->skipCheckCallback(function ($request) {
			// Skip token check for API URLs.
			if($request->getParam('action') === 'thumbnail') {
				return true;
			}
		});
		
        $middlewareQueue
			// Catch any exceptions in the lower layers,
			// and make an error page/response
			->add(new ErrorHandlerMiddleware(Configure::read('Error')))
	
			// Handle plugin/theme assets like CakePHP normally does.
			->add(new AssetMiddleware([
				'cacheTime' => Configure::read('Asset.cacheTime'),
			]))

			// Add routing middleware.
			// If you have a large number of routes connected, turning on routes
			// caching in production could improve performance. For that when
			// creating the middleware instance specify the cache config name by
			// using it's second constructor argument:
			// `new RoutingMiddleware($this, '_cake_routes_')`
			->add(new RoutingMiddleware($this))

			// Parse various types of encoded request bodies so that they are
			// available as array through $request->getData()
			// https://book.cakephp.org/4/en/controllers/middleware.html#body-parser-middleware
			->add(new BodyParserMiddleware())
		
			->add(new AuthenticationMiddleware($this))

			// Cross Site Request Forgery (CSRF) Protection Middleware
			// https://book.cakephp.org/4/en/security/csrf.html#cross-site-request-forgery-csrf-middleware
			->add($csrf /*new CsrfProtectionMiddleware()*/);
			
		return $middlewareQueue;
    }


	/**
	 * Returns a service provider instance.
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request
	 * @return \Authentication\AuthenticationServiceInterface
	 */
	public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface {
	    $service = new AuthenticationService();

	    // Define where users should be redirected to when they are not authenticated
	    $service->setConfig([
		  'unauthenticatedRedirect' => Router::url([
			    'prefix' => false,
			    'plugin' => null,
			    'controller' => 'Users',
			    'action' => 'login',
		  ]),
		  'queryParam' => 'redirect',
	    ]);

	    $fields = [
			IdentifierInterface::CREDENTIAL_USERNAME => 'email',
			IdentifierInterface::CREDENTIAL_PASSWORD => 'password'
	    ];
	    // Load the authenticators. Session should be first.
	    $service->loadAuthenticator('Authentication.Session');
	    $service->loadAuthenticator('Authentication.Form', [
			'fields' => $fields,
			'loginUrl' => Router::url([
				'prefix' => false,
				'plugin' => null,
				'controller' => 'Users',
				'action' => 'login',
		  ]),
	    ]);
	    // Load identifiers
	    $service->loadIdentifier('Authentication.Password', [
		    'fields' => $fields,
		    /*'passwordHasher' => [
				'className' => 'Authentication.md5'
		    ],*/
		]);

	    return $service;
	}
	
    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     * @link https://book.cakephp.org/4/en/development/dependency-injection.html#dependency-injection
     */
    public function services(ContainerInterface $container): void {
    }

    /**
     * Bootstrapping for CLI application.
     *
     * That is when running commands.
     *
     * @return void
     */
    protected function bootstrapCli(): void {
		$this->addOptionalPlugin('Cake/Repl');
		$this->addOptionalPlugin('Bake');
		  
		$this->addPlugin('Migrations');
		// Load more plugins here
    }
}
