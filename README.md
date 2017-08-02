Visitation
==========

Installation
------------

```sh
$ composer require geniv/nette-visitation
```
or
```json
"geniv/nette-visitation": ">=1.0.0"
```

require:
```json
"php": ">=5.6.0",
"nette/nette": ">=2.4.0",
"dibi/dibi": ">=3.0.0",
"geniv/nette-locale": ">=1.0.0"
```

Include in application
----------------------

neon configure:
```neon
services:
    - Visitation(%tablePrefix%)
```

usage:
```latte
{control visitation}
```

presenters:
```php
use Visitation;

protected function createComponentVisitation(Visitation $visitation)
{
    $visitation->getMessage()
        ->setFrom($this->context->parameters['emailSetup']['visitation']['from'])
        ->addTo($this->context->parameters['emailSetup']['visitation']['to'])
        ->addBcc($this->context->parameters['emailSetup']['visitation']['bcc'])
        ->setSubject('Sjednání prohlídky');

    $visitation->onSuccess[] = function ($values) {
        $this->flashMessage($this->translator->translate('visitation-onsuccess'), 'info');
        $this->redirect('this');
    };
    return $visitation;
}
```
