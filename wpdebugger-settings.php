<?php
$options = get_option('wpdebugger_config', null);
    
    if (!$options){
        $options = array(
            'enablelogger' => false,
            'loggers' => array(),
            'themedebug' => false,
            'databasedebug' => false
        );
    }
?>
<div class="wrap">
<h1>Wordpress Debugger settings</h1>
<?php
if (isset($_POST['action']))
{
    $options['themedebug'] = isset($_POST['themedebug']);
    $options['databasedebug'] = isset($_POST['databasedebug']);
    $options['enablelogger'] = isset($_POST['enablelogger']);
    $options['loggers'] = explode(',',trim($_POST['loggers']));
    update_option('wpdebugger_config', $options);
    ?>
<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
<p><strong>Settings saved.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
<?php
}
?>
<form method="post" action="" novalidate="novalidate">
<input type="hidden" name="action" value="update" />

<table class="form-table">
<tbody>

<tr>
<th scope="row">Enable Logger</th>
<td> <fieldset><legend class="screen-reader-text"><span>Enable</span></legend><label for="enablelogger">
<input name="enablelogger" type="checkbox" id="enablelogger" value="1" <?php echo $options['enablelogger'] ? 'checked="checked"' : ''; ?>/>
Enable</label>
</fieldset></td>
</tr>

<tr>
<th scope="row"><label for="loggers">Log Debug Ids</label></th>
<td><input name="loggers" type="text" id="loggers" value="<?php echo join(",",$options['loggers']); ?>" class="regular-text" />
<p class="description" id="tagline-description">Debug Ids. Split by comma</p></td>
</tr>

<tr>
<th scope="row">Enable Database Debug</th>
<td> <fieldset><legend class="screen-reader-text"><span>Enable</span></legend><label for="databasedebug">
<input name="databasedebug" type="checkbox" id="databasedebug" value="1" <?php echo $options['databasedebug'] ? 'checked="checked"' : ''; ?>/>
Enable</label>
</fieldset></td>
</tr>

<tr>
<th scope="row">Enable Theme Debug</th>
<td> <fieldset><legend class="screen-reader-text"><span>Enable</span></legend><label for="themedebug">
<input name="themedebug" type="checkbox" id="themedebug" value="1" <?php echo $options['themedebug'] ? 'checked="checked"' : ''; ?>/>
Enable</label>
</fieldset></td>
</tr>

</tbody></table>

<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes" /></p></form>

</div>