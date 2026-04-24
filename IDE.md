# IDE

## VS Code

### Extensiones Recomendadas

En la raíz del proyecto, cree o edite el archivo `.vscode/extensions.json`

```json
{
    "recommendations": [
        "bmewburn.vscode-intelephense-client",
        "onecentlin.laravel-blade",
        "amiralizadeh9480.laravel-extra-intellisense",
        "ryannaddy.laravel-artisan",
        "shufo.vscode-blade-formatter",
        "mehedidracula.php-namespace-resolver",
        "xdebug.php-debug",
        "mikestead.dotenv",
        "editorconfig.editorconfig",
        "open-southeners.laravel-pint"
    ]
}
```

### Configuración

En la raíz del proyecto, cree o edite el archivo `.vscode/settings.json`

```json
{
    "editor.formatOnSave": true,
    "editor.defaultFormatter": "shufo.vscode-blade-formatter",
    "files.associations": {
        "*.blade.php": "blade"
    },
    "intelephense.files.exclude": [
        "**/.git/**",
        "**/node_modules/**"
    ]
}
```
