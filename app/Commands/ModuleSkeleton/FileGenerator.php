<?php

namespace App\Commands\ModuleSkeleton;

/**
 * Class FileGenerator
 *
 * Responsável por gerar automaticamente os arquivos-base de um módulo
 * no CodeIgniter 4, incluindo:
 * - Controllers
 * - Models
 * - Entities
 * - Services
 * - Views
 * - Arquivos de Rotas
 *
 * Essa classe encapsula toda a construção dos templates e gravação
 * dos arquivos no diretório correto do módulo.
 */
class FileGenerator
{

    /**
     * Gera a View inicial (index.php) do módulo.
     *
     * @param string $path      Caminho base do módulo (ex: app/Modules/Blog/)
     * @param string $module    Nome do módulo
     *
     * @return void
     */
    public function createView(string $path, string $module): void
    {
        $content = $this->viewTemplate($module);

        file_put_contents($path . "Views/index.php", $content);
    }

    /**
     * Gera o arquivo de rotas do módulo (Config/Routes.php).
     *
     * @param string $path      Caminho base do módulo
     * @param string $module    Nome do módulo
     *
     * @return void
     */
    public function createRoutes(string $path, string $module): void
    {
        $content = $this->routesTemplate($module);
        file_put_contents($path . "Config/Routes.php", $content);
    }

    /**
     * Gera o Controller base do módulo.
     *
     * @param string $path      Caminho do módulo
     * @param string $module    Nome do módulo
     *
     * @return void
     */
    public function createController(string $path, string $module): void
    {
        $content = $this->createBaseController($module);
        file_put_contents($path . "Controllers/{$module}Controller.php", $content);
    }

    /**
     * Gera o Service base do módulo.
     *
     * @param string $path      Caminho do módulo
     * @param string $module    Nome do módulo
     *
     * @return void
     */
    public function createService(string $path, string $module): void
    {
        $content = $this->createBaseService($module);
        file_put_contents($path . "Services/{$module}Service.php", $content);
    }

    /**
     * Gera o Model base do módulo.
     *
     * @param string $path      Caminho do módulo
     * @param string $module    Nome do módulo
     *
     * @return void
     */
    public function createModel(string $path, string $module): void
    {
        $content = $this->createBaseModel($module);
        file_put_contents($path . "Models/{$module}Model.php", $content);
    }

    /**
     * Gera a Entity base do módulo.
     *
     * @param string $path      Caminho do módulo
     * @param string $module    Nome do módulo
     *
     * @return void
     */
    public function createEntity(string $path, string $module): void
    {
        $content = $this->createBaseEntity($module);
        file_put_contents($path . "Entities/{$module}.php", $content);
    }

    /**
     * Template base do Controller.
     *
     * @param string $module    Nome do módulo
     *
     * @return string           Conteúdo do arquivo gerado
     */
    private function createBaseController(string $module): string
    {
        $content = <<<PHP
<?php

namespace App\Modules\\$module\Controllers;

use App\Controllers\BaseController;

class {$module}Controller extends BaseController
{
    /**
     * Página inicial padrão do módulo.
     *
     * @return \CodeIgniter\HTTP\Response|string
     */
    public function index()
    {
        return view('App\\Modules\\$module\\Views\\index');
    }
}
PHP;

        return $content;
    }

    /**
     * Template base do Model.
     *
     * @param string $module
     * @return string
     */
    private function createBaseModel(string $module): string
    {
        $table = strtolower($module);

        $content = <<<PHP
<?php

namespace App\Modules\\$module\Models;

use CodeIgniter\\Model;

class {$module}Model extends Model
{
    /**
     * Nome da tabela associada.
     * @var string
     */
    protected \$table = '$table';

    /**
     * Chave primária.
     * @var string
     */
    protected \$primaryKey = 'id';

    /**
     * Campos permitidos para inserção/atualização.
     * @var array
     */
    protected \$allowedFields = [];
}
PHP;

        return $content;
    }

    /**
     * Template base da Entity.
     *
     * @param string $module
     * @return string
     */
    private function createBaseEntity(string $module): string
    {
        $content = <<<PHP
<?php

namespace App\Modules\\$module\Entities;

use CodeIgniter\\Entity\\Entity;

/**
 * Entity base do módulo $module.
 */
class {$module} extends Entity
{
}
PHP;

        return $content;
    }

    /**
     * Template base do Service.
     *
     * @param string $module
     * @return string
     */
    private function createBaseService(string $module): string
    {
        $content = <<<PHP
<?php

namespace App\Modules\\$module\Services;

/**
 * Service base do módulo $module.
 * Contém regras de negócio e operações de domínio.
 */
class {$module}Service
{
    // Defina regras de negócios aqui
}
PHP;

        return $content;
    }

    /**
     * Template de rotas dinâmicas do módulo.
     *
     * @param string $module
     * @return string
     */
    private function routesTemplate(string $module): string
    {
        $moduleName = strtolower($module);

        $content = <<<PHP
<?php

namespace App\Modules\\$module\Config;

use CodeIgniter\\Router\\RouteCollection;

/**
 * Rotas do módulo $module.
 *
 * @var RouteCollection \$routes
 */
\$routes->group('$moduleName', ['namespace' => 'App\Modules\\$module\Controllers'], function(\$routes){
    \$routes->get('/', '{$module}Controller::index');
});
PHP;

        return $content;
    }

    /**
     * Gera o HTML da view inicial super minimalista e moderna.
     *
     * @param string $module
     * @return string
     */
    private function viewTemplate(string $module): string
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
        h1 { margin-bottom: 10px; }
        p { margin-top: 0; color: #555; }
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
    <p>Use este ponto de partida para desenvolver funcionalidades específicas do seu módulo.</p>
    <p>Desenvolvido por 
        <strong><a href="https://demezio.ct.ws/" target="_blank">Henrique Demézio.</a></strong>
    </p>
</div>

<div class="footer">
    <p>&copy; {$data} Henrique Demézio – Todos os direitos reservados.</p>
</div>

</body>
</html>
HTML;

        return $content;
    }
}
