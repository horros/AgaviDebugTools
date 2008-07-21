<?php
//define some helper methods

function _s($string) {
  return htmlspecialchars($string);
}
?>

<div id="adt-container">
  <h1>Debug Log</h1>

  <div id="sections">
    <h2>Matched Routes</h2>
    <div id="section-routing">
      <?php foreach($template['routes'] as $routeName => $routeInfo): ?>
      <h3><?php echo $routeName ?></h3>
      <div id="route-<?php echo md5($routeName); ?>">
        <dl>
          <dt>Module</dt>
            <dd><?php echo $routeInfo['opt']['module']; ?></dd>
          <dt>Action</dt>
            <dd><?php echo $routeInfo['opt']['action']; ?></dd>
          <dt>Stop</dt>
            <dd><?php echo $routeInfo['opt']['stop']==true ? 'True' : 'False'; ?></dd>
          <dt>Parameters</dt>
          <dd>
            <?php if(count($routeInfo['par'])): ?>
            <ul>
            <?php foreach( $routeInfo['par'] as $oneParameter ): ?>
              <li><strong><?php echo $oneParameter ?></strong><br />
              Default
              <?php if ( isset($routeInfo['opt']['defaults'][$oneParameter]) ): ?>
              <ul>
                <li>Pre: <?php echo $routeInfo['opt']['defaults'][$oneParameter]['pre']; ?></li>
                <li>Value: <?php echo $routeInfo['opt']['defaults'][$oneParameter]['val']; ?></li>
                <li>Post: <?php echo $routeInfo['opt']['defaults'][$oneParameter]['post']; ?></li>
              </ul>
                      <?php else: ?>
              No default
                      <?php endif; ?>
              Required: <?php echo !isset($routeInfo['opt']['optional_parameters'][$oneParameter]) ? 'False' : 'True'; ?>
              </li>
            <?php endforeach; ?>
            </ul>
            <?php else: ?>
            No Parameters
            <?php endif; ?>
          </dd>
        </dl>
        <strong>Output type</strong>:
        <?php
          $otName = empty($routeInfo['opt']['output_type']) ? $this->getContext()->getController()->getOutputType()->getName() : $routeInfo['opt']['output_type'];
          $outputType = $this->getContext()->getController()->getOutputType($otName);
        ?>
        <?php echo $otName;  ?>

        <div>
          Has renderers:  <?php echo $outputType->hasRenderers()==true ? 'True' : 'False'; ?><br />
          Default layout name: <?php echo $outputType->getDefaultLayoutName(); ?>
        </div>
        <?php
        if ( strcmp($this->getContext()->getController()->getOutputType()->getName(), $routeInfo['opt']['output_type']) == 0 ) {
          echo ' ( default ) ';
        }
        ?>
        <br />

        <strong>Parameters</strong>:
        <?php if ( count( $routeInfo['opt']['parameters'] ) != 0 ): ?>
        <ul>
        <?php foreach( $routeInfo['opt']['parameters'] as $parameter ): ?>
          <li><?php echo $parameter; ?></li>
        <?php endforeach; ?>
        </ul>
        <?php else: ?>
          No parameters
        <?php endif; ?>

        <br/>Ignores:
        <?php if ( count( $routeInfo['opt']['ignores'] ) != 0 ): ?>
        <ul>
        <?php foreach( $routeInfo['opt']['ignores'] as $ignore ): ?>
          <li><?php echo $ignore; ?></li>
        <?php endforeach; ?>
        </ul>
        <?php else: ?>
          No ignores
        <?php endif; ?>
        <br />

        Children
        <?php if (count($routeInfo['opt']['childs']) != null ): ?>
          <ul>
          <?php foreach( $routeInfo['opt']['childs'] as $children ): ?>
            <li>'.$children.'</li>
          <?php endforeach; ?>
          </ul>
        <?php endif; ?>
        <br />

        Callback: <?php echo $routeInfo['opt']['callback']; ?>
        <br />
        Imply: <?php echo $routeInfo['opt']['imply']==true?'True':'False'; ?>
        <br />
        Cut: <?php echo $routeInfo['opt']['cut']==true?'True':'False'; ?>
        <br />
        rpx: <?php echo _s($routeInfo['rxp']); ?>

      </div><!-- route -->
    <?php endforeach; //routes ?>
    </div><!-- routing -->

    <h2>Global Request Data</h2>
    <div id="adtBlock_Request" >
      <?php foreach( $template['request_data'] as $parameter ): ?>
        <?php echo $parameter; ?>
        <br />
      <?php endforeach; ?>
    </div>

    <h2>Actions</h2>
    <div id="adtBlock_View" >
    <?php foreach($template['actions'] as $action): ?>
      <h3><?php echo $action['module']; ?>.<?php echo $action['name']; ?></h3>
      <?php echo $action['view']; ?>
    <?php endforeach; ?>
    </div>
    
    <h2>FPF</h2>
    <div>
      FormPopulationFilter TODO
    </div>

    <?php if ( AgaviConfig::get('core.use_database') ): ?>
    <h2>Databases</h2>
    <div>
      <strong>Class name</strong>: <?php echo $template['database']['class_name']; ?>
    </div>
    <?php endif; ?>
    
    <?php if ( AgaviConfig::get('core.use_translation') ): ?>
    <h2>Translation</h2>
    <div>
      <strong>Current locale</strong>: <?php echo $template['tm']->getCurrentLocaleIdentifier(); ?>
      <br />
      <strong>Default locale</strong>: <?php echo $template['tm']->getDefaultLocaleIdentifier(); ?>
    
      <br /><br />
    
      <strong>Available locales</strong>
      <br />
      <ul>
        <?php foreach ( $template['tm']->getAvailableLocales() as $locale ): ?>
        <li>
          <strong><?php echo $locale['parameters']['description']; ?></strong>
          <br />
          Identifier: <?php echo $locale['identifier']; ?>
          <br />
          Language: <?php echo $locale['identifierData']['language'] ?>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>

    <h2>Environment</h2>
    <div>
      <strong>Environment</strong>: <?php echo AgaviConfig::get('core.environment'); ?>
      <br />
      <strong style="text-decoration: underline;">Settings</strong>
      <br /><br />
      <strong style="text-decoration: underline;">Defaults</strong>
      <br />
      <strong>Module</strong>: <?php echo AgaviConfig::get('actions.default_module'); ?>
      <br />
      <strong>Action</strong>: <?php echo AgaviConfig::get('actions.default_action'); ?>
      <br /><br />
      <strong>404</strong>
      <br />
      <strong>Module</strong>: <?php echo AgaviConfig::get('actions.error_404_module'); ?>
      <br />
      <strong>Action</strong>: <?php echo AgaviConfig::get('actions.error_404_action'); ?>
      <br /><br />
      <strong>Unavailable</strong>
      <br />
      <strong>Module</strong>: <?php echo AgaviConfig::get('actions.module_disabled_module'); ?>
      <br />
      <strong>Action</strong>: <?php echo AgaviConfig::get('actions.module_disabled_action'); ?>
      <br /><br />
      <strong>Disabled</strong>
      <br />
      <strong>Module</strong>: <?php echo AgaviConfig::get('actions.unavailable_module'); ?>
      <br />
      <strong>Action</strong>: <?php echo AgaviConfig::get('actions.unavailable_action'); ?>
      <br /><br />
      <strong>Secure</strong>
      <br />
      <strong>Module</strong>: <?php echo AgaviConfig::get('actions.secure_module'); ?>
      <br />
      <strong>Action</strong>: <?php echo AgaviConfig::get('actions.secure_action'); ?>
      <br /><br />
      <strong>Login</strong>
      <br />
      <strong>Module</strong>: <?php echo AgaviConfig::get('actions.login_module'); ?>
      <br />
      <strong>Action</strong>: <?php echo AgaviConfig::get('actions.login_action'); ?>
      <br />

      <br />
      <strong style="text-decoration: underline;">Locations</strong>
      <br />
      <strong>App</strong>: <?php echo AgaviConfig::get('core.app_dir'); ?>
      <br />
      <strong>Cache</strong>: <?php echo AgaviConfig::get('core.cache_dir'); ?>
      <br />
      <strong>Config</strong>: <?php echo AgaviConfig::get('core.config_dir'); ?>
      <br />
      <strong>Lib</strong>: <?php echo AgaviConfig::get('core.lib_dir'); ?>
      <br />
      <strong>Modules:</strong>: <?php echo AgaviConfig::get('core.module_dir'); ?>
      <br />
      <strong>Templates</strong>: <?php echo AgaviConfig::get('core.template_dir'); ?>

      <br />
      <br />
      <strong style="text-decoration: underline;">Agavi</strong>
      <br />
      <strong>Version</strong>: <?php echo AgaviConfig::get('agavi.version'); ?>
      <br />
      <strong>Location</strong>: <?php echo AgaviConfig::get('core.agavi_dir'); ?>
    </div>
    
    <h2>Log</h2>
    <div>
      <?php foreach($template['log'] as $logLine): ?>
        <?php echo $logLine['timestamp']->format('c') ?>: <?php echo _s($logLine['message']); ?><br/>
      <?php endforeach; ?>
    </div>
  </div><!-- sections / tabs -->
</div>
