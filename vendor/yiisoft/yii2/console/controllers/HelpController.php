<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\console\controllers;

use Yii;
use yii\base\Application;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\Console;
use yii\helpers\Inflector;

/**
 * Provides help information about console commands.
 *
 * This command displays the available command list in
 * the application or the detailed instructions about using
 * a specific command.
 *
 * This command can be used as follows on command line:
 *
 * ~~~
 * yii help [command name]
 * ~~~
 *
 * In the above, if the command name is not provided, all
 * available commands will be displayed.
 *
 * @property array $commands All available command names. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelpController extends Controller
{
    /**
     * Displays available commands or the detailed information
     * about a particular command.
     *
     * @param string $command The name of the command to show help about.
     * If not provided, all available commands will be displayed.
     * @return integer the exit status
     * @throws Exception if the command for help is unknown
     */
    public function actionIndex($command = null)
    {
        if ($command !== null) {
            $result = Yii::$app->createController($command);
            if ($result === false) {
                throw new Exception(Yii::t('yii', 'No help for unknown command "{command}".', [
                    'command' => $this->ansiFormat($command, Console::FG_YELLOW),
                ]));
            }

            list($controller, $actionID) = $result;

            $actions = $this->getActions($controller);
            if ($actionID !== '' || count($actions) === 1 && $actions[0] === $controller->defaultAction) {
                $this->getSubCommandHelp($controller, $actionID);
            } else {
                $this->getCommandHelp($controller);
            }
        } else {
            $this->getDefaultHelp();
        }
    }

    /**
     * Returns all available command names.
     * @return array all available command names
     */
    public function getCommands()
    {
        $commands = $this->getModuleCommands(Yii::$app);
        sort($commands);
        return array_unique($commands);
    }

    /**
     * Returns an array of commands an their descriptions.
     * @return array all available commands as keys and their description as values.
     */
    protected function getCommandDescriptions()
    {
        $descriptions = [];
        foreach ($this->getCommands() as $command) {
            $description = '';

            $result = Yii::$app->createController($command);
            if ($result !== false) {
                list($controller, $actionID) = $result;
                /** @var Controller $controller */
                $description = $controller->getHelpSummary();
            }

            $descriptions[$command] = $description;
        }

        return $descriptions;
    }

    /**
     * Returns all available actions of the specified controller.
     * @param Controller $controller the controller instance
     * @return array all available action IDs.
     */
    public function getActions($controller)
    {
        $actions = array_keys($controller->actions());
        $class = new \ReflectionClass($controller);
        foreach ($class->getMethods() as $method) {
            $name = $method->getName();
            if ($method->isPublic() && !$method->isStatic() && strpos($name, 'action') === 0 && $name !== 'actions') {
                $actions[] = Inflector::camel2id(substr($name, 6), '-', true);
            }
        }
        sort($actions);

        return array_unique($actions);
    }

    /**
     * Returns available commands of a specified module.
     * @param \yii\base\Module $module the module instance
     * @return array the available command names
     */
    protected function getModuleCommands($module)
    {
        $prefix = $module instanceof Application ? '' : $module->getUniqueID() . '/';

        $commands = [];
        foreach (array_keys($module->controllerMap) as $id) {
            $commands[] = $prefix . $id;
        }

        foreach ($module->getModules() as $id => $child) {
            if (($child = $module->getModule($id)) === null) {
                continue;
            }
            foreach ($this->getModuleCommands($child) as $command) {
                $commands[] = $command;
            }
        }

        $controllerPath = $module->getControllerPath();
        if (is_dir($controllerPath)) {
            $files = scandir($controllerPath);
            foreach ($files as $file) {
                if (!empty($file) && substr_compare($file, 'Controller.php', -14) === 0) {
                    $controllerClass = $module->controllerNamespace . '\\' . substr(basename($file), 0, -4);
                    if ($this->validateControllerClass($controllerClass)) {
                        $commands[] = $prefix . Inflector::camel2id(substr(basename($file), 0, -14));
                    }
                }
            }
        }

        return $commands;
    }

    /**
     * Validates if the given class is a valid console controller class.
     * @param string $controllerClass
     * @return bool
     */
    protected function validateControllerClass($controllerClass)
    {
        if (class_exists($controllerClass)) {
            $class = new \ReflectionClass($controllerClass);
            return !$class->isAbstract() && $class->isSubclassOf('yii\console\Controller');
        } else {
            return false;
        }
    }

    /**
     * Displays all available commands.
     */
    protected function getDefaultHelp()
    {
        $commands = $this->getCommandDescriptions();
        if (!empty($commands)) {
            $this->stdout("\nThe following commands are available:\n\n", Console::BOLD);
            $len = 0;
            foreach ($commands as $command => $description) {
                if (($l = strlen($command)) > $len) {
                    $len = $l;
                }
            }
            foreach ($commands as $command => $description) {
                echo "- " . $this->ansiFormat($command, Console::FG_YELLOW);
                echo str_repeat(' ', $len + 3 - strlen($command)) . $description;
                echo "\n";
            }
            $scriptName = $this->getScriptName();
            $this->stdout("\nTo see the help of each command, enter:\n", Console::BOLD);
            echo "\n  $scriptName " . $this->ansiFormat('help', Console::FG_YELLOW) . ' '
                            . $this->ansiFormat('<command-name>', Console::FG_CYAN) . "\n\n";
        } else {
            $this->stdout("\nNo commands are found.\n\n", Console::BOLD);
        }
    }

    /**
     * Displays the overall information of the command.
     * @param Controller $controller the controller instance
     */
    protected function getCommandHelp($controller)
    {
        $controller->color = $this->color;

        $this->stdout("\nDESCRIPTION\n", Console::BOLD);
        $comment = $controller->getHelp();
        if ($comment !== '') {
            $this->stdout("\n$comment\n\n");
        }

        $actions = $this->getActions($controller);
        if (!empty($actions)) {
            $this->stdout("\nSUB-COMMANDS\n\n", Console::BOLD);
            $prefix = $controller->getUniqueId();
            foreach ($actions as $action) {
                echo '- ' . $this->ansiFormat($prefix.'/'.$action, Console::FG_YELLOW);
                if ($action === $controller->defaultAction) {
                    $this->stdout(' (default)', Console::FG_GREEN);
                }
                $summary = $controller->getActionHelpSummary($controller->createAction($action));
                if ($summary !== '') {
                    echo ': ' . $summary;
                }
                echo "\n";
            }
            $scriptName = $this->getScriptName();
            echo "\nTo see the detailed information about individual sub-commands, enter:\n";
            echo "\n  $scriptName " . $this->ansiFormat('help', Console::FG_YELLOW) . ' '
                            . $this->ansiFormat('<sub-command>', Console::FG_CYAN) . "\n\n";
        }
    }

    /**
     * Displays the detailed information of a command action.
     * @param Controller $controller the controller instance
     * @param string $actionID action ID
     * @throws Exception if the action does not exist
     */
    protected function getSubCommandHelp($controller, $actionID)
    {
        $action = $controller->createAction($actionID);
        if ($action === null) {
            throw new Exception(Yii::t('yii', 'No help for unknown sub-command "{command}".', [
                'command' => rtrim($controller->getUniqueId() . '/' . $actionID, '/'),
            ]));
        }

        $description = $controller->getActionHelp($action);
        if ($description != '') {
            $this->stdout("\nDESCRIPTION\n", Console::BOLD);
            $this->stdout("\n$description\n\n");
        }

        $this->stdout("\nUSAGE\n\n", Console::BOLD);
        $scriptName = $this->getScriptName();
        if ($action->id === $controller->defaultAction) {
            echo $scriptName . ' ' . $this->ansiFormat($controller->getUniqueId(), Console::FG_YELLOW);
        } else {
            echo $scriptName . ' ' . $this->ansiFormat($action->getUniqueId(), Console::FG_YELLOW);
        }

        $args = $controller->getActionArgsHelp($action);
        foreach ($args as $name => $arg) {
            if ($arg['required']) {
                $this->stdout(' <' . $name . '>', Console::FG_CYAN);
            } else {
                $this->stdout(' [' . $name . ']', Console::FG_CYAN);
            }
        }

        $options = $controller->getActionOptionsHelp($action);
        $options[\yii\console\Application::OPTION_APPCONFIG] = [
            'type' => 'string',
            'default' => null,
            'comment' => "custom application configuration file path.\nIf not set, default application configuration is used.",
        ];
        ksort($options);

        if (!empty($options)) {
            $this->stdout(' [...options...]', Console::FG_RED);
        }
        echo "\n\n";

        if (!empty($args)) {
            foreach ($args as $name => $arg) {
                echo $this->formatOptionHelp(
                        '- ' . $this->ansiFormat($name, Console::FG_CYAN),
                        $arg['required'],
                        $arg['type'],
                        $arg['default'],
                        $arg['comment']) . "\n\n";
            }
        }

        if (!empty($options)) {
            $this->stdout("\nOPTIONS\n\n", Console::BOLD);
            foreach ($options as $name => $option) {
                echo $this->formatOptionHelp(
                        $this->ansiFormat('--' . $name, Console::FG_RED, empty($option['required']) ? Console::FG_RED : Console::BOLD),
                        !empty($option['required']),
                        $option['type'],
                        $option['default'],
                        $option['comment']) . "\n\n";
            }
        }
    }

    /**
     * Generates a well-formed string for an argument or option.
     * @param string $name the name of the argument or option
     * @param boolean $required whether the argument is required
     * @param string $type the type of the option or argument
     * @param mixed $defaultValue the default value of the option or argument
     * @param string $comment comment about the option or argument
     * @return string the formatted string for the argument or option
     */
    protected function formatOptionHelp($name, $required, $type, $defaultValue, $comment)
    {
        $comment = trim($comment);
        $type = trim($type);
        if (strncmp($type, 'bool', 4) === 0) {
            $type = 'boolean, 0 or 1';
        }

        if ($defaultValue !== null && !is_array($defaultValue)) {
            if ($type === null) {
                $type = gettype($defaultValue);
            }
            if (is_bool($defaultValue)) {
                // show as integer to avoid confusion
                $defaultValue = (int) $defaultValue;
            }
            if (is_string($defaultValue)) {
                $defaultValue = "'" . $defaultValue . "'";
            } else {
                $defaultValue = var_export($defaultValue, true);
            }
            $doc = "$type (defaults to " . $defaultValue . ")";
        } else {
            $doc = $type;
        }

        if ($doc === '') {
            $doc = $comment;
        } elseif ($comment !== '') {
            $doc .= "\n" . preg_replace("/^/m", "  ", $comment);
        }

        $name = $required ? "$name (required)" : $name;

        return $doc === '' ? $name : "$name: $doc";
    }

    /**
     * @return string the name of the cli script currently running.
     */
    protected function getScriptName()
    {
        return basename(Yii::$app->request->scriptFile);
    }
}
