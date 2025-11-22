<?php

namespace App\Commands;

use App\Commands\ModuleSkeleton\FileGenerator;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * Class MakeModule
 *
 * Comando CLI responsável por gerar automaticamente a estrutura
 * completa de um módulo no CodeIgniter 4.
 *
 * Este comando cria:
 * - Diretórios padrão do módulo
 * - Arquivo de rotas
 * - Controller inicial
 * - Model base
 * - Entity base
 * - Service base
 * - View inicial
 *
 * Uso:
 *  php spark make:module Blog
 *
 * @package App\Commands
 */
class MakeModule extends BaseCommand
{
    /**
     * Agrupamento exibido no spark list.
     * @var string
     */
    protected $group = 'Generators';

    /**
     * Nome do comando.
     * @var string
     */
    protected $name = 'make:module';

    /**
     * Descrição breve do comando.
     * @var string
     */
    protected $description = 'It generates a complete module structure.';

    /**
     * Exemplo de uso exibido no terminal.
     * @var string
     */
    protected $usage = 'make:module <ModuleName>';

    /**
     * Lista de argumentos aceitos.
     * @var array
     */
    protected $arguments = [
        'ModuleName' => 'Name of the module to be created'
    ];

    /**
     * Executa o comando para gerar o módulo.
     *
     * @param array $params
     * Nome do módulo fornecido no terminal.
     *
     * @return void
     */
    public function run(array $params)
    {
        $generator = new FileGenerator();

        $name = $params[0] ?? null;

        if ($name === null || !$name) {
            CLI::error("Você deve informar um nome de módulo. Ex: php spark make:module Users");
            return;
        }

        $module = ucfirst($name);
        $basePath = APPPATH . "Modules/{$module}/";

        /**
         * Diretórios padrão do módulo.
         * @var array
         */
        $dirs = [
            "Config",
            "Controllers",
            "Models",
            "Entities",
            "Database/Migrations",
            "Services",
            "Views",
        ];

        // Aviso inicial
        CLI::write("[-] Aguarde... Criando módulo: {$module}", 'yellow');

        // Criar diretórios
        foreach ($dirs as $uniqueDir) {
            $path = $basePath . $uniqueDir;

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
                CLI::write("[+] Criado: {$path}", 'dark_gray');
            }
        }

        // Gerar arquivos base
        $generator->createRoutes($basePath, $module);
        $generator->createController($basePath, $module);
        $generator->createModel($basePath, $module);
        $generator->createEntity($basePath, $module);
        $generator->createService($basePath, $module);
        $generator->createView($basePath, $module);

        // Sucesso!
        CLI::write("[+] Módulo $module gerado com sucesso!", 'green');
    }
}
