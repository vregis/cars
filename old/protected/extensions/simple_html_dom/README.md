Yii simple_html_dom
===================

A copy of the [PHP Simple HTML DOM Parser project](http://simplehtmldom.sourceforge.net/) usable as Yii extension.

## Installation

Extract of git clone this repository to protected/extensions/simple_html_dom

## Usage

```php
Yii::import('ext.simple_html_dom.*');

$dom = new SimpleHtmlDom();
$dom->load($html);

foreach ($dom->getRoot()->getElementsByTagName('input') as $el) {
	//...
}
```

Check the [official documentation at SourceForge](http://simplehtmldom.sourceforge.net/manual.htm).
