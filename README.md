# Agenciafmd – Filament Leads

Pacote de Leads para o painel administrativo (Admix) baseado em Filament v4 e Laravel 12. Ele fornece o CRUD completo de leads (model, migração, resource Filament, tabela, formulários, fábrica e seeder), incluindo auditoria e suporte a eventos para criação automática de leads.

## Requisitos

- PHP ^8.4
- Laravel ^12.0
- Filament ^4.0
- agenciafmd/filament-admix v1.x-dev | dev-master

## Instalação

1. Instale o pacote via Composer:

```bash
composer require agenciafmd/filament-leads
```

2. Execute as migrações:

```bash
php artisan migrate
```

3. (Opcional) Popule o banco com dados falsos:

```bash
php artisan db:seed --class=Agenciafmd\\Leads\\Database\\Seeders\\LeadSeeder
```

## Ativando no painel Filament

Este pacote inclui um Plugin Filament que registra o `LeadResource` automaticamente. Adicione o plugin na config do admix `config/filament-admix.php`:

```php
use Agenciafmd\Leads\LeadsPlugin;

return [
    'plugins' => [
        LeadsPlugin::class,
    ],
];
```

Após isso, o menu "Leads" aparecerá no painel, com as páginas de Listar, Criar e Editar.

## Recursos incluídos

- Model: `Agenciafmd\Leads\Models\Lead` (com Soft Deletes, HasFactory, Auditing e limpeza programada via `prunable()`)
- Migração: cria a tabela `leads` com campos principais (`source`, `name`, `email`, `phone`, `description`, flag `is_active`, timestamps e soft deletes)
- Factory e Seeder: `LeadFactory` e `LeadSeeder`
- Resource Filament: `LeadResource` com páginas `ListLeads`, `CreateLead`, `EditLead`
- Tabela: `LeadsTable` com colunas, filtros (inclusive `Trashed`), ações em lote e ordenação padrão
- Eventos: Suporte a criação de leads através de listeners.
- Traduções pt_BR prontas

## Configuração

Arquivo: `config/filament-leads.php`

```php
return [
    'name' => 'Leads',
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

As chaves em `fields` definem os nomes de campos que o `LeadService` tentará mapear automaticamente ao criar um lead a partir de dados genéricos.

## Auditoria

O `LeadResource` inclui o relation manager `Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager`, exibindo o histórico de auditorias quando o pacote `tapp/filament-auditing` for utilizado pelo projeto via `filament-admix`.

## Licença

Este pacote é software livre e está disponível nos termos da licença MIT.
