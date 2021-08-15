<?php

namespace Aqua\Emerald\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;
use DOMDocument;
use DOMNode;
use DOMElement;

class Markup extends Component
{
    public $make;

    public $dom;
    public $lastElement;

    const SELF_TERMINATE = [
        'area','base','basefont','br','col','embed','frame','hr','img','input','link','meta','param','source','track','wbr'
    ];

    public function __construct($make) {
        $this->dom = new DOMDocument();
        $this->make = $make;
    }

    // public function appendHTML(DOMNode $parent, $source) {
    //     $tmpDoc = new DOMDocument();
    //     $tmpDoc->loadHTML($source);
    //     foreach ($tmpDoc->getElementsByTagName('body')->item(0)->childNodes as $node) {
    //         $node = $parent->ownerDocument->importNode($node, true);
    //         $parent->appendChild($node);
    //     }
    // }

    public function generateMarkup(string $slotContent) : string
    {
        $parts = explode('>', $this->make);
        $parts = array_map('trim', $parts);

        foreach ($parts as $part) {
            if (Str::contains($part, '+')) {
                $siblings = explode('+', $part);

                $first = true;
                foreach ($siblings as $sibling) {
                    if($this->lastElement) {
                        $element = $this->makeElement($sibling);

                        if($first) {
                            $this->lastElement->appendChild($element);
                        }
                        else {
                            $appendTo = ( $this->lastElement && isset($this->lastElement->parentNode) ) ? $this->lastElement->parentNode : $this->dom;
                            $appendTo->appendChild($element);
                        }

                        $this->lastElement = $element;
                    }

                    $first = false;
                }

                $this->lastElement = isset($this->lastElement->parentNode) ? $this->lastElement->parentNode : $this->dom;

                continue;
            }

            $element = $this->makeElement($part);
            $appendTo = $this->lastElement ?: $this->dom;
            $appendTo->appendChild($element);

            $this->lastElement = $element;
        }

        if($slotContent) {
            $template = $this->dom->createDocumentFragment();
            $template->appendXML($slotContent);
            $this->lastElement->appendChild($template);
        }

        return $this->dom->saveHTML();
    }

    private function extractId(string $part) : null|string
    {
        if(Str::contains($part, '#')) {
            // when starting with id like: p.#foo.test
            if(preg_match("/(?<=\#)(\w+)\.+/", $part, $match)) {
                return $match[1];
            }

            // when ending with id like: p.test#foo
            if(preg_match("/\#(\w+)\b(?!\.)$/", $part, $match)) {
                return $match[1];
            }

            [$el, $id] = explode('#', $part);

            return $id;
        }

        return null;
    }

    private function extractClass(string $part) : null|string
    {
        $items = explode('.', $part);

        if(count($items) === 1) return null;

        unset($items[0]);
        return implode(' ', $items);
    }

    private function extractCustomAttributes(string $part) : null|array
    {
        if(preg_match("/\[(.+)\]/", $part, $match)) {

            if(preg_match_all('/\s?(?P<attribute>.+?)\=(\"|\')(?P<value>.+?)(\"|\')/', $match[1], $attributeMatches)) {
                $attributes = $attributeMatches['attribute'];
                $values = $attributeMatches['value'];

                return [
                    str_replace($match[0], '', $part),
                    array_combine($attributes, $values)
                ];
            }
        }

        return null;
    }

    private function makeElement(string $part) : DOMElement
    {
        $attributes = [];

        // extract custom attributes
        if($customAttributes = $this->extractCustomAttributes($part)) {
            [$partWithoutCustomAttributes, $customAttrDataList] = $customAttributes;
            $attributes = $customAttrDataList;

            $part = $partWithoutCustomAttributes;
        }

        // extract id
        if($id = $this->extractId($part)) {
            $attributes['id'] = $id;

            $part = str_replace('#'.$id, '', $part);
        }

        $el = $part;

        // extract class attribute
        if($class = $this->extractClass($part)) {
            $attributes['class'] = $class;

            $items = explode('.', $part);
            $el = $items[0];
        }

        throw_if(in_array($el, self::SELF_TERMINATE), new \InvalidArgumentException('Blade-Emerald parse error: Self-Closing Tags not supported'));

        if($class) $attributes['class'] = $class;
        if($id) $attributes['id'] = $id;

        return $this->createElementWithAttributes($el, $attributes);
    }

    private function createElementWithAttributes(string $el, array $attributes) : DOMElement {
        try {
            $element = $this->dom->createElement($el);

            if($attributes) {
                foreach ($attributes as $key => $value) {
                    if($this->isInnerText($key)) {
                        $this->setInnerText($element, $value);
                        continue;
                    }

                    $element->setAttribute($key, $value);
                }
            }

        } catch (\Exception $th) {
            throw new \InvalidArgumentException('Blade-Emerald parse error: '. $th->getMessage());
        }

        return $element;
    }

    private function isInnerText(string $key) : bool {
        return $key == 'data-innerText';
    }

    private function setInnerText(DOMElement $element, string $content) : void {
        $node = $this->dom->createTextNode($content);
        $element->appendChild($node);
    }

    public function render()
    {
        return view('emerald::components.emerald');
    }
}
