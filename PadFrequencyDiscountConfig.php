<?php namespace ProcessWire;

/**
 * Class PadFrequencyDiscountConfig
 */
class PadFrequencyDiscountConfig extends ModuleConfig {

  /**
   * array Default config values
   */
  public function getDefaults() {
    return array(
      'checkout_template' => '',
      'discount_template' => '',
      'categoryfield' => '',
      'quantityfield' => '',
      'disable_for_couponcode' => false
    );
  }

  /**
   * Retrieves the list of config input fields
   * Implementation of the ConfigurableModule interface
   *
   * @return InputfieldWrapper
   */
  public function getInputfields() {
    // get inputfields
    $inputfields = parent::getInputfields();

    $field = $this->modules->get('InputfieldSelect');
    $field->name = 'checkout_template';
    $field->label = __('Checkout template');
    $field->description = __('Choose the template, that is used as checkout template.');
    $field->icon = 'cart-plus';
    $field->columnWidth = 50;
    foreach ($this->templates->getAll() as $key => $template) {
        // include only non-system templates and repeaters
        if ($template->flags & Template::flagSystem) {
          if (substr($template->name, 0, 9) === 'repeater_') $field->addOption($key, $template);
        } else {
          $field->addOption($key, $template);
        }
    }
    $inputfields->add($field);

    $field = $this->modules->get('InputfieldSelect');
    $field->name = 'discount_template';
    $field->label = __('discount template');
    $field->description = __('Choose the template, that is used as discount template.');
    $field->icon = 'percent';
    $field->columnWidth = 50;
    foreach ($this->templates->getAll() as $key => $template) {
        // include only non-system templates and repeaters
        if ($template->flags & Template::flagSystem) {
          if (substr($template->name, 0, 9) === 'repeater_') $field->addOption($key, $template);
        } else {
          $field->addOption($key, $template);
        }
    }
    $inputfields->add($field);

    $field = $this->modules->get('InputfieldSelect');
    $field->name = 'categoryfield';
    $field->columnWidth = 50;
    $field->label = __('category Field');
    $field->description = __('You can choose any options field from your system - it will use that as a category field.');
    $field->icon = 'tag';
    foreach ($this->fields->find('type=FieldtypeOptions') as $f) $field->addOption($f->name, $f->title);
    $inputfields->add($field);

    $field = $this->modules->get('InputfieldSelect');
    $field->name = 'quantityfield';
    $field->columnWidth = 50;
    $field->label = __('quantity Field');
    $field->description = __('You can choose any options field from your system - it will use that as a quantity field.');
    $field->icon = 'cubes';
    foreach ($this->fields->find('type=FieldtypeInteger') as $f) $field->addOption($f->name, $f->title);
    $inputfields->add($field);

    $field = $this->modules->get('InputfieldCheckbox');
    $field->attr('name', 'disable_for_couponcode');
    $field->columnWidth = 50;
    $field->label = $this->_('May not be assigned in conjunction with a coupon code.');
    if (!$this->modules->isInstalled('PadCouponCode')) $field->collapsed = Inputfield::collapsedHidden;
    $inputfields->add($field);

    return $inputfields;
  }

}
