# Filament – Leads

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/filament-leads.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/filament-leads)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Adiciona ao Admix o CRUD de leads, com exportação em CSV/XLSX e criação automática de leads a partir dos formulários enviados pelo `agenciafmd/filament-postal`.

## Requisitos

- PHP ^8.4
- Laravel ^12.0 | ^13.0
- Filament ^5.0
- agenciafmd/filament-admix v1.x-dev | dev-master
- (Opcional) agenciafmd/filament-postal, para a criação automática de leads

## Instalação

1. Instale o pacote via Composer:

```bash
composer require agenciafmd/filament-leads
```

2. Execute as migrações:

```bash
php artisan migrate
```

3. Populando o banco com dados de testes

Adicione o seeder no `database/seeders/DatabaseSeeder.php`:

```php
use Agenciafmd\Leads\Database\Seeders\LeadSeeder;

$this->call([
    LeadSeeder::class,
]);
```

Ou rode o seeder manualmente:

```bash
php artisan db:seed --class="Agenciafmd\Leads\Database\Seeders\LeadSeeder"
```

## Ativando no painel

Adicione o plugin na config do admix `config/filament-admix.php`:

```php
use Agenciafmd\Leads\LeadsPlugin;

return [
    'plugins' => [
        LeadsPlugin::class,
    ],
];
```

Após isso, o menu **Leads** aparecerá no painel, com as páginas de Listar, Criar e Editar. A listagem tem a ação de exportação (CSV e XLSX) no cabeçalho.

## Configuração

Arquivo: `config/filament-leads.php`

```php
return [
    'name' => 'Leads',
    'navigation_group' => null,
    'navigation_sort' => 4,
    'fields' => [
        'name' => [
            'name',
            'nome',
        ],
        'email' => [
            'e-mail',
            'email',
        ],
        'phone' => [
            'telefone',
            'phone',
            'celular',
            'mobile',
        ],
    ],
    'sources' => [
        'newsletter' => 'Newsletter',
    ],
];
```

| Chave              | Padrão                                  | Descrição                                                                                           |
|--------------------|-----------------------------------------|-----------------------------------------------------------------------------------------------------|
| `name`             | `Leads`                                 | Nome do pacote.                                                                                     |
| `navigation_group` | `null`                                  | Grupo do menu em que o Resource aparece (`null` = sem grupo).                                       |
| `navigation_sort`  | `4`                                     | Posição do item no menu.                                                                            |
| `fields.name`      | `['name', 'nome']`                      | Nomes de campo (em minúsculas) que são gravados na coluna `name` do lead.                           |
| `fields.email`     | `['e-mail', 'email']`                   | Nomes de campo que são gravados na coluna `email`.                                                  |
| `fields.phone`     | `['telefone', 'phone', 'celular', 'mobile']` | Nomes de campo que são gravados na coluna `phone`.                                             |
| `sources`          | `['newsletter' => 'Newsletter']`        | Origens extras (`slug => nome`) exibidas no campo e no filtro "Origem", além dos formulários do Postal. |

Leads na lixeira há mais de 30 dias são removidos pelo `model:prune`, agendado diariamente às 03h (minuto definido em `filament-admix.schedule.minutes`).

## Uso

Com o `agenciafmd/filament-postal` instalado, o listener `Agenciafmd\Leads\Listeners\CreateLead` escuta o evento `Agenciafmd\Postal\Events\NotificationSent` e cria um lead a cada formulário enviado:

- `source` recebe o `slug` do formulário do Postal;
- os campos cujos nomes estão em `fields` são gravados em `name`, `email` e `phone`;
- os demais campos são concatenados em `description`, um por linha, no formato `Campo: valor`.

As opções de origem (`source`) combinam os formulários cadastrados no Postal com as origens de `sources` na config, via `Agenciafmd\Leads\Services\LeadService::sources()`.

## Permissões

O `LeadResource` entra automaticamente no controle de permissões por Grupos do Admix. Usuários sem grupo são administradores e têm acesso total.

## Auditoria

O `LeadResource` inclui o relation manager `Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager`, exibindo o histórico de auditorias do registro.

## Licença

Este pacote é software livre e está disponível nos termos da licença MIT.
