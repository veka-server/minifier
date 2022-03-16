# minifier
minifier middleware

# install

```
composer require veka-server/minifier
```

# utilisation

Exemple d'utilisation 
```js
$tableau_middleware[] = new \VekaServer\Minifier\Minifier(
    ['css_folder_1','css_folder_2', ...] // list css folders
    , ['js_folder_1','js_folder_2', ...] // list js folders
    ,86400 // cache time ms
);
```

Exemple d'utilisation dans le framework veka-server/app
```php
//...
$tableau_middleware[] = new \VekaServer\Minifier\Minifier(
    \VekaServer\Framework\Plugin::getInstance()->getAllCSSFolders()
    , \VekaServer\Framework\Plugin::getInstance()->getAllJSFolders()
    ,86400
);
//...
```
