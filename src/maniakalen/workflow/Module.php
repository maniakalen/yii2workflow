<?php
/**
 * PHP Version 5.5
 *
 *  Module definition for Yii2 framework 
 *
 * @category Data flow 
 * @package  linear\workflow
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     - 
 */

namespace maniakalen\workflow;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Application;
use yii\helpers\ArrayHelper;

/**
 * Class Module
 *
 *  Module definition for Yii2 framework
 *
 * @category Data flow
 * @package  linear\workflow
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    const ROUTES_APP_FRONTEND = 'frontend';
    const ROUTES_APP_BACKEND = 'backend';

    public $controllerNamespace;
    public $routes;
    public $events;
    public $container;
    public $appComponents;
    public $app;
    public $appTypes = [];
    public $appendRoutes = true;
    /**
     * Module initialisation
     *
     * @return null
     */
    public function init()
    {
        parent::init();
        Yii::setAlias('@maniakalen/workflow', dirname(__FILE__));
        $this->loadConfigs();
        if (!$this->controllerNamespace) {
            $this->controllerNamespace = Yii::getAlias('@maniakalen/workflow/controllers');
        }

        $this->prepareEvents();
        $this->prepareContainer();
        if (isset($config['aliases']) && !empty($config['aliases'])) {
            Yii::$app->setAliases($config['aliases']);
        }
        return null;
    }

    /**
     * Protected method to register events defined in config
     *
     * @return null
     */
    protected function prepareEvents()
    {
        if (!empty($this->events)) {
            foreach ($this->events as $event) {
                if (isset($event['class']) && isset($event['event'])
                    && isset($event['callback']) && is_callable($event['callback'])
                ) {
                    Event::on($event['class'], $event['event'], $event['callback']);
                }
            }
        }

        return null;
    }

    /**
     * Protected method to add container definition from the config file
     *
     * @return null
     */
    protected function prepareContainer()
    {
        if (!empty($this->container)) {
            if (isset($this->container['definitions'])) {
                $definitions = ArrayHelper::merge(Yii::$container->getDefinitions(), $this->container['definitions']);
                Yii::$container->setDefinitions($definitions);
            }
        }

        return null;
    }

    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     *
     * @return null
     */
    public function bootstrap($app)
    {
        if (isset($this->app['base'])) {
            foreach ($this->app['base'] as $param => $values) {
                $app->$param = ArrayHelper::merge($app->$param, $values);
            }
        }
        if (is_array($this->appComponents) && !empty($this->appComponents)) {
            $app->setComponents(ArrayHelper::merge($app->getComponents(), $this->appComponents));
        }
        if ($app instanceof \yii\web\Application) {
            if (isset($this->app['web'])) {
                foreach ($this->app['web'] as $param => $values) {
                    $app->$param = ArrayHelper::merge($app->$param, $values);
                }
            }
            $this->loadRoutes($app);
        }
        if ($app instanceof \yii\console\Application) {
            if (isset($this->app['console'])) {
                foreach ($this->app['console'] as $param => $values) {
                    $app->$param = ArrayHelper::merge($app->$param, $values);
                }
            }
            $this->controllerNamespace = 'maniakalen\workflow\console\controllers';
        }
        return null;
    }

    protected function loadRoutes(\yii\web\Application $app)
    {
        if (is_array($this->routes) && !empty($this->routes)) {
            $routes = [];
            foreach ($this->routes as $key => $item) {
                $key = str_replace('[module]', $this->id, $key);
                $item = str_replace('[module]', $this->id, $item);
                $routes[$key] = $item;
            }
            $app->getUrlManager()->addRules($routes, $this->appendRoutes);
        }
    }

    protected function loadConfigs()
    {
        $config = include Yii::getAlias('@maniakalen/workflow/config/main.php');
        if (in_array(self::ROUTES_APP_BACKEND, $this->appTypes)) {
            $config = ArrayHelper::merge($config, include Yii::getAlias('@maniakalen/workflow/config/backend.php'));
        }
        if (in_array(self::ROUTES_APP_FRONTEND, $this->appTypes)) {
            $config = ArrayHelper::merge($config, include Yii::getAlias('@maniakalen/workflow/config/frontend.php'));
        }

        Yii::configure($this, $config);
    }
}