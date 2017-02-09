<?php namespace ProcessWire;

/**
 * Class GithubConnectConfig
 */
class GithubConnectConfig extends ModuleConfig {

  private function getModuleName() {
    return substr($this->className(), 0, - strlen('Config'));
  }

  /**
   * array Default config values
   */
  public function getDefaults() {
    $redirectUri = $this->pages->get($this->config->adminRootPageID)->httpUrl . 'module/edit?name=' . $this->getModuleName() . '&collapse_info=1';

    return array(
      'clientId' => '',
      'clientSecret' => '',
      'redirectUri' => $redirectUri,
      'organization' => '',
      'accessToken' => '',
      'beImport' => false,
      'fieldSelect' => '',
      'fieldSubSelect' => '',
      'fieldPlain' => '',
      'fieldTeaser' => '',
      'fieldBody' => ''
    );
  }

  /**
   * Retrieves the list of config input fields
   * Implementation of the ConfigurableModule interface
   *
   * @return InputfieldWrapper
   */
  public function getInputfields() {
    $inputfields = parent::getInputfields();
    $redirectUri = $this->getDefaults()['redirectUri'];
    $link = $this->modules->get($this->getModuleName())->authorize();

    $help = $this->modules->get('InputfieldMarkup');
    $helpContent = <<<EOD
<h2>Instructions:</h2>
<ol>
<li>Register a new <a href="https://github.com/settings/applications/new">OAuth Application at Github</a>. It's really important to add the following url as Authorization callback URL: <code>$redirectUri</code></li>
<li>Complete the form below, leaving the access input token field empty. This value will be generated. Click submit.</li>
<li>Click the following link to generate code and access token: $link</li>
</ol>
<p><a  target="_blank" href="https://github.com/justonestep/processwire-instagramfeed">Read more</a></p>
EOD;
    $help->value = $helpContent;
    $inputfields->add($help);

    // field organization
    $field = $this->modules->get('InputfieldText');
    $field->name = 'organization';
    $field->label = __('Organization');
    $inputfields->add($field);

    // field app ID
    $field = $this->modules->get('InputfieldText');
    $field->name = 'clientId';
    $field->label = __('Github Client ID');
    $field->columnWidth = 50;
    $field->required = 1;
    $inputfields->add($field);

    // field app secret
    $field = $this->modules->get('InputfieldText');
    $field->name = 'clientSecret';
    $field->label = __('Github Client Secret');
    $field->columnWidth = 50;
    $field->required = 1;
    $inputfields->add($field);

    // field redirect URI
    $field = $this->modules->get('InputfieldText');
    $field->name = 'redirectUri';
    $field->label = __('Authorization callback URL');
    $field->collapsed = Inputfield::collapsedNoLocked;
    $field->columnWidth = 50;
    $inputfields->add($field);

    // field Access Token
    $field = $this->modules->get('InputfieldText');
    $field->name = 'accessToken';
    $field->label = __('Github Access Token');
    $field->columnWidth = 50;
    $field->collapsed = Inputfield::collapsedNoLocked;
    $inputfields->add($field);

    // field fieldSelect
    $field = $this->modules->get('InputfieldSelect');
    $field->label = __('Select list Github repositories');
    $field->description = __('Field which should be filled with Github repositories.');
    $field->notes = __('Type Option, all fields must be added to the same template.');
    $field->attr('name', 'fieldSelect');
    $field->columnWidth = 25;
    $field->required = 1;
    $field->requiredIf = "clientSecret!=''";
    foreach ($this->fields as $f) {
      if (!$f->type instanceof \ProcessWire\FieldtypeOptions) continue;
      $field->addOption($f->name, $f->name);
    }
    $inputfields->add($field);

    // field fieldPlain
    $field = $this->modules->get('InputfieldSelect');
    $field->label = __('Selected Github repository');
    $field->description = __('Field which should store the selected Github repository.');
    $field->notes = __('Type Text, all fields must be added to the same template.');
    $field->attr('name', 'fieldPlain');
    $field->columnWidth = 25;
    $field->required = 1;
    $field->requiredIf = "clientSecret!=''";
    foreach ($this->fields as $f) {
      if (!$f->type instanceof \ProcessWire\FieldtypeText || $f->type instanceof \ProcessWire\FieldtypeTextarea) continue;
      $field->addOption($f->name, $f->name);
    }
    $inputfields->add($field);

    // field fieldTeaser
    $field = $this->modules->get('InputfieldSelect');
    $field->label = __('Teaser Text');
    $field->description = __('Field which should contain the imported `description` content.');
    $field->notes = __('Type Textarea, all fields must be added to the same template.');
    $field->attr('name', 'fieldTeaser');
    $field->columnWidth = 25;
    foreach ($this->fields as $f) {
      if (!$f->type instanceof \ProcessWire\FieldtypeTextarea) continue;
      $field->addOption($f->name, $f->name);
    }
    $inputfields->add($field);

    // field fieldBody
    $field = $this->modules->get('InputfieldSelect');
    $field->label = __('Body Text');
    $field->description = __('Field which should contain the imported `readme`-file content.');
    $field->notes = __('Type Textarea, all fields must be added to the same template.');
    $field->attr('name', 'fieldBody');
    $field->columnWidth = 25;
    $field->required = 1;
    $field->requiredIf = "clientSecret!=''";
    foreach ($this->fields as $f) {
      if (!$f->type instanceof \ProcessWire\FieldtypeTextarea) continue;
      $field->addOption($f->name, $f->name);
    }
    $inputfields->add($field);

    // field fieldSubSelect
    $field = $this->modules->get('InputfieldSelect');
    $field->label = __('Select list repositories files');
    $field->description = __('Field which should be filled with files of a Github repositories.');
    $field->notes = __('Type Option, all fields must be added to the same template.');
    $field->attr('name', 'fieldSubSelect');
    $field->columnWidth = 25;
    foreach ($this->fields as $f) {
      if (!$f->type instanceof \ProcessWire\FieldtypeOptions) continue;
      $field->addOption($f->name, $f->name);
    }
    $inputfields->add($field);


    return $inputfields;
  }

}
