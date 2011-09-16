<?php
if ( !empty($_GET['json']) ) {
	
	$dirs = array();
	
	$rep=opendir('.');
	$bAuMoinsUnRepertoire = false;
	while ($file = readdir($rep)){
		if($file != '..' && $file !='.' && $file !=''  && $file !='lib' && substr($file,0,1)!="." ){ 
			if (is_dir($file)){
				
				$dirs[] = array(
					'name' => $file,
					'path' => './' . $file
				);
				
			}
		}
	}
	
	echo json_encode(array('dirs'=>$dirs));
	
	exit;

}
?><!DOCTYPE html>
<html>
    <head>
        <title>TestApp</title>
        
        <!-- Sencha Touch -->
        <link href="../___sencha_touch___/resources/css/sencha-touch.css" rel="stylesheet" type="text/css" />
        <script src="../___sencha_touch___/sencha-touch.js" type="text/javascript"></script>
		
		<script type="text/javascript">
		Ext.setup({ onReady:function(){
			
			var myMask;
			
			
			Ext.regModel('Dir',{
				fields: ['name','path']
			});
			
			Ext.regStore('Dirs',{
				model: 		'Dir',
				autoLoad: 	true,
				
				proxy: {
					type: 'ajax',
					url: './?json=1',
					reader: {
						type: 'json',
						root: 'dirs'
					}
				},
				
			});
			
			
			
			var listItemSelect = function( ui, item, uu ) {
				document.location.href = item.data.path;
			}
			
			
			
			var viewport = new Ext.Panel({
				fullscreen:			true,
				scroll:				'vertical',
				
				dockedItems: [{
					xtype: 'toolbar',
					title: 'SenchaTouch Demos',
					items: [{
						text: 'Up',
						ui: 'back',
						handler: function() {
							document.location.href = "../";
						}
					}]
				},{
					xtype: 'toolbar',
					ui: 'light',
					dock: 'bottom',
					title: '<?php echo dirname(__FILE__).DIRECTORY_SEPARATOR; ?>'
				}],
				
				items: [{
					xtype:				'list',
					store:				'Dirs',
					itemTpl:			'<a href="{path}" target="_blank" style="color:#036;text-shadow:0 1px 0 #fff;text-decoration:none;">{name}</a>',
					disableSelection: 	true,
				}],
				
				// Startup logic - setup the mask and panel's content.
				listeners: {
					afterrender: function(){
						
					}
				}
			}).show();
			
			var DirsMask = new Ext.LoadMask(Ext.getBody(),{ store: 'Dirs' });
			
			
		}});
		</script>
		
	</head>
	<body></body>
</html>