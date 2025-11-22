<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeModule extends BaseCommand
{
    protected $group        = 'Generators';
    protected $name         = 'make:module';
    protected $description  = 'It generates a complete module structure.';
    protected $usage        = 'make:module <ModuleName>';
    protected $arguments    = [
        'ModuleName' => 'Name of the module to be created'
    ];

    public function run(array $params)
    {
        // Implementation of the command

        $name = $params[0];

        if ($name === null || !$name) {
            CLI::error("Você deve informar um nome de módulo. Ex: php spark make:module Users");
            return;
        }

        $module = ucfirst($name);
        $basePath = APPPATH . "Modules/{$module}/";

        // Definir os diretórios do módulo
        $dirs = [
            "Config",
            "Controllers",
            "Models",
            "Entities",
            "Database/Migrations",
            "Services",
            "Views",
        ];

        // Mostrar mensagem inicial
        CLI::write("[-] Aguarde... Criando módulo: {$module}", 'yellow');

        // Percorrer os caminhos e criar os diretórios
        foreach ($dirs as $uniqueDir) {
            $path = $basePath . $uniqueDir;

            // Verificar se o diretório já existe, se não, criar
            if (! is_dir($path)) {
                mkdir($path, 0777, true);
                // Mostrar mensagem de diretório criado
                CLI::write("[+] Criado: {$path}", 'dark_gray');
            }
        }

        // Cria o o arquivo de rotas
        $this->createRoutes($basePath, $module);

        // Cria o Controller básico
        $this->createController($basePath, $module);

        // Cria o Model básico
        $this->createModel($basePath, $module);

        // Cria a Entity básica
        $this->createEntity($basePath, $module);

        // Cria o Service básico
        $this->createService($basePath, $module);

        // Cria a View básica
        $this->createView($basePath, $module);

        // Envia uma mensagems de sucesso
        CLI::write("[+] Módulo $module gerado com sucesso!", 'green');
    }

    private function createRoutes($base, $module)
    {
        $moduleName = strtolower($module);
        $content = <<<PHP
<?php

namespace App\Modules\\$module\Config;

use CodeIgniter\\Router\\RouteCollection;

/** @var RouteCollection \$routes */
\$routes->group('$moduleName', ['namespace' => 'App\Modules\\$module\Controllers'], function(\$routes){
    \$routes->get('/', '{$module}Controller::index');
});
PHP;

        file_put_contents($base . "Config/Routes.php", $content);
    }
    private function createController($base, $module)
    {
        $content = <<<PHP
<?php

namespace App\Modules\\$module\Controllers;

use App\Controllers\BaseController;

class {$module}Controller extends BaseController
{
    public function index()
    {
        return view('App\\Modules\\$module\\Views\\index');
    }
}
PHP;

        file_put_contents($base . "Controllers/{$module}Controller.php", $content);
    }

    private function createModel($base, $module)
    {

        $table = strtolower($module);
        $content = <<<PHP
<?php

namespace App\Modules\\$module\Models;

use CodeIgniter\\Model;

class {$module}Model extends Model
{
    protected \$table = '$table';
    protected \$primaryKey = 'id';
    protected \$allowedFields = [];
}
PHP;

        file_put_contents($base . "Models/{$module}Model.php", $content);
    }

    private function createEntity($base, $module)
    {
        $content = <<<PHP
<?php

namespace App\Modules\\$module\Entities;

use CodeIgniter\\Entity\\Entity;

class {$module} extends Entity
{
}
PHP;

        file_put_contents($base . "Entities/{$module}.php", $content);
    }

    private function createService($base, $module)
    {
        $content = <<<PHP
<?php

namespace App\Modules\\$module\Services;

class {$module}Service
{
    // Aqui vão regras de negócios
}
PHP;

        file_put_contents($base . "Services/{$module}Service.php", $content);
    }

    private function createView($base, $module)
    {
        $data = date('Y');
        $content = <<<HTML
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$module Module</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 40px;
            text-align: center;
            color: #333;
        }
        .box {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        }
        h1 {
            margin-bottom: 10px;
        }
        p {
            margin-top: 0;
            color: #555;
        }
        p a {
            color: #007BFF;
            text-decoration: none;
        }
        .footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="box">
        <h1>Módulo: <strong>$module</strong></h1>
        <p>Gerado automaticamente pelo <strong>Gerador Modular</strong>.</p>
        <p>Desenvolvido por <strong><a href="https://demezio.ct.ws/" target="_blank" rel="noopener noreferrer">Henrique Demézio.</a></strong></p>
    </div>

    <div class="footer">
        <p>&copy; " . {$data} . " Henrique Demézio – Todos os direitos reservados.</p>
    </div>

</body>
</html>
HTML;

        file_put_contents($base . "Views/index.php", $content);
    }
}
