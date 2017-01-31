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
      'cacheExpire' => 'daily',
      'accessToken' => ''
    );
  }

  /**
   * Retrieves the list of config input fields
   * Implementation of the ConfigurableModule interface
   *
   * @return InputfieldWrapper
   */
  public function getInputfields() {
    // get submitted data
    $cacheExpire = isset($this->data['cacheExpire']) ? $this->data['cacheExpire'] : 'daily';

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
    $field->required = 1;
    $field->collapsed = Inputfield::collapsedNoLocked;
    $field->columnWidth = 50;
    $inputfields->add($field);

    // Access Token
    $field = $this->modules->get('InputfieldText');
    $field->name = 'accessToken';
    $field->label = __('Github Access Token');
    $field->columnWidth = 50;
    $field->collapsed = Inputfield::collapsedNoLocked;
    $inputfields->add($field);

    // field cache ID
    $field = $this->modules->get('InputfieldSelect');
    $field->label = 'Cache expires';
    $field->description = __('By default a cache lasts for one day. You could select another lifetime.');
    $field->attr('name', 'cacheExpire');
    $field->attr('value', $cacheExpire);
    $field->columnWidth = 100;
    $field->required = 1;
    $lifetimes = array('never', 'save', 'now', 'hourly', 'daily', 'weekly', 'monthly');
    foreach($lifetimes as $lifetime) {
      $field->addOption($lifetime, $lifetime);
    }
    $inputfields->add($field);

    return $inputfields;
  }

}
