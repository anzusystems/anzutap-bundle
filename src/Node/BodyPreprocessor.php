<?php

namespace AnzuSystems\AnzutapBundle\Node;

class BodyPreprocessor
{
    public function prepareBody(string $body): string
    {
        return $this->fixHtml(
            $this->minifyHtml($body)
        );
    }
    protected function fixHtml(string $html): string
    {
        return '<?xml encoding="utf-8" ?>' . $html;
    }

    protected function minifyHtml(string $html): string
    {
        /** @var string $html */
        $html = preg_replace('/^\\s+|\\s+$/mu', '', $html);
        /** @var string $html */
        $html = preg_replace('/\\s+(<\\/?(?:area|article|aside|base(?:font)?|blockquote|body'
            . '|canvas|caption|center|col(?:group)?|dd|dir|div|dl|dt|fieldset|figcaption|figure|footer|form'
            . '|frame(?:set)?|h[1-6]|head|header|hgroup|hr|html|legend|li|link|main|map|menu|meta|nav'
            . '|ol|opt(?:group|ion)|output|p|param|section|t(?:able|body|head|d|h||r|foot|itle)'
            . '|ul|video)\\b[^>]*>)/iu', '$1', $html);

        return $html;
    }
}
