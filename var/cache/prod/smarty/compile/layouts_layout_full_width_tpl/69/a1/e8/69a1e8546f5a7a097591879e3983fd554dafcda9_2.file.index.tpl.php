<?php
/* Smarty version 3.1.33, created on 2020-02-04 10:32:51
  from '/var/www/paginagrupo3.com/html/themes/classic/templates/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5e393a43bc4fa3_01096181',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '69a1e8546f5a7a097591879e3983fd554dafcda9' => 
    array (
      0 => '/var/www/paginagrupo3.com/html/themes/classic/templates/index.tpl',
      1 => 1580804778,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e393a43bc4fa3_01096181 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4012416685e393a43bb4860_73945800', 'page_content_container');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'page.tpl');
}
/* {block 'page_content_top'} */
class Block_847775355e393a43bb7681_94167817 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_content_top'} */
/* {block 'hook_home'} */
class Block_5092672015e393a43bbcec8_13568114 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <?php echo $_smarty_tpl->tpl_vars['HOOK_HOME']->value;?>

          <?php
}
}
/* {/block 'hook_home'} */
/* {block 'page_content'} */
class Block_10226180255e393a43bbaa34_33000034 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5092672015e393a43bbcec8_13568114', 'hook_home', $this->tplIndex);
?>

        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_4012416685e393a43bb4860_73945800 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'page_content_container' => 
  array (
    0 => 'Block_4012416685e393a43bb4860_73945800',
  ),
  'page_content_top' => 
  array (
    0 => 'Block_847775355e393a43bb7681_94167817',
  ),
  'page_content' => 
  array (
    0 => 'Block_10226180255e393a43bbaa34_33000034',
  ),
  'hook_home' => 
  array (
    0 => 'Block_5092672015e393a43bbcec8_13568114',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <section id="content" class="page-home">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_847775355e393a43bb7681_94167817', 'page_content_top', $this->tplIndex);
?>


        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10226180255e393a43bbaa34_33000034', 'page_content', $this->tplIndex);
?>

      </section>
    <?php
}
}
/* {/block 'page_content_container'} */
}
