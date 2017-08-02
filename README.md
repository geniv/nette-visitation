Translator
==========

This translator is target for save ident in message, also default text is for id_locale=NULL, 
next language must be translate manual.

Plurals source: http://docs.translatehouse.org/projects/localization-guide/en/latest/l10n/pluralforms.html

Installation
------------

```sh
$ composer require geniv/nette-translator
```
or
```json
"geniv/nette-translator": ">=1.0"
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

available source drivers:
- Database (dibi + cache)
- Neon (filesystem)
- DevNull (ignore translate)

neon configure:
```neon
# translator
translator:
#   debugger: false
#   source: "DevNull"
    source: "Database"
    tablePrefix: %tablePrefix%
#   source: "Neon"
#   path: %appDir%
```

neon configure extension:
```neon
extensions:
    translator: Translator\Bridges\Nette\Extension
```


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


usage:
```latte
{_'preklad'}
{_'preklad', $pocet}
```

latte translate with devnull source:
```latte
{_'preklad', $pocet, ['%s 0x', '%s 1x', '%s 2x+']}
```

**this latte macro is not supported, because like index must use be simple string `{_'xyz'}`**:
```latte
{_}preklad{/_}
```

presenters:
```php
/** @var ITranslator @inject */
public $translator;

// nastaveni na formular
$form = new \Nette\Application\UI\Form;
$form->setTranslator($this->translator);
```
or
```php
// prelozeni textu
$this->translator->translate('message-ident');
```
