<?php
namespace TwbBundle\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;

class TwbBundleFormStatic extends AbstractHelper
{
    /**
     * @var string
     */
    private static $staticFormat = '<%s class="form-control-static%s"%s>%s</%s>';

    /**
     * @var array
     */
     private static $ignoredAttributes = ['type', 'tag', 'class'];

    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @return string|TwbBundleFormStatic
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * @see \Zend\Form\View\Helper\AbstractHelper::render()
     * @param ElementInterface $oElement
     * @return string
     */
    public function render(ElementInterface $oElement)
    {
        $sTag = $this->getTagFromElement($oElement);
        return $this->renderElement($sTag, $oElement->getValue(), $this->getClassFromElement($oElement), $this->getAttributesFromElement($oElement));
    }

    /**
     * @param ElementInterface $oElement
     * @return string
     */
    public function getTagFromElement(\Zend\Form\ElementInterface $oElement)
    {
        $sTag = $oElement->getAttribute('tag');
        return ($sTag && preg_match("/^[a-z][a-z0-9._-]*$/", $sTag) ? $sTag : 'p');
    }

   /**
     * @param ElementInterface $oElement
     * @return string
     */
    public function getClassFromElement(\Zend\Form\ElementInterface $oElement)
    {
        $sClass = $oElement->getAttribute('class');
        return ($sClass ? ' ' . $sClass : '');
    }

    /**
     * @param ElementInterface $oElement
     * @return string
     */
    public function getAttributesFromElement(\Zend\Form\ElementInterface $oElement)
    {
        $aAttributes = $oElement->getAttributes();
        return is_array($aAttributes) ? ' ' . $this->createAttributesString(array_diff_key($aAttributes, array_flip(self::$ignoredAttributes))) : '';
    }

    /**
     * @param string $sTag
     * @param string $sElementContent
     * @param string $sRowClass
     * @param string $sElementAttributes
     * @return string
     * @throws \InvalidArgumentException
     */
    public function renderElement($sTag, $sElementContent, $sRowClass, $sElementAttributes)
    {
        if (!is_string($sTag)) {
            throw new \InvalidArgumentException('Argument "$sTag" expects a string, "' . (is_object($sTag) ? get_class($sTag) : gettype($sTag)) . '" given');
        }
        if (!is_string($sElementContent)) {
            throw new \InvalidArgumentException('Argument "$sElementContent" expects a string, "' . (is_object($sElementContent) ? get_class($sElementContent) : gettype($sElementContent)) . '" given');
        }
        if (!is_string($sRowClass)) {
            throw new \InvalidArgumentException('Argument "$sRowClass" expects a string, "' . (is_object($sRowClass) ? get_class($sRowClass) : gettype($sRowClass)) . '" given');
        }
        if (!is_string($sElementAttributes)) {
            throw new \InvalidArgumentException('Argument "$sElementAttributes" expects a string, "' . (is_object($sElementAttributes) ? get_class($sElementAttributes) : gettype($sElementAttributes)) . '" given');
        }
        return sprintf(self::$staticFormat, $sTag, $sRowClass, $sElementAttributes, $sElementContent, $sTag) . PHP_EOL;
    }
}
