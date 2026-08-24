<?php
$dir='C:/Users/imomn/Desktop/epro.uz/wp-theme/epro-classic';
$rii=new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir,FilesystemIterator::SKIP_DOTS));
$s=[];$fns='esc_html__|esc_attr__|esc_html_e|esc_attr_e|__|_e|_x|esc_attr_x';
$re='/\b(?:'.$fns.')\(\s*\'((?:[^\'\\]|\\.)*)\'\s*(?:,\s*\'((?:[^\'\\]|\\.)*)\')?/';
foreach($rii as $f){if($f->getExtension()!=='php')continue;$c=file_get_contents($f->getPathname());
if(preg_match_all($re,$c,$m,PREG_SET_ORDER))foreach($m as $h){$d=isset($h[2])?$h[2]:'';if($d!==''&&$d!=='epro-classic')continue;$id=str_replace(array("\'",'\\'),array("'",'\'),$h[1]);if($id!=='')$s[$id]=true;}}
ksort($s);
$o="# Translation template for the EPRO — Classic theme.\n# Copyright (C) ".gmdate('Y')." EPRO\n# Distributed under GPL-2.0-or-later.\nmsgid \"\"\nmsgstr \"\"\n\"Project-Id-Version: EPRO - Classic 1.0.0\n\"\n\"Content-Type: text/plain; charset=UTF-8\n\"\n\"Content-Transfer-Encoding: 8bit\n\"\n\"X-Domain: epro-classic\n\"\n\n";
foreach(array_keys($s) as $x){$e=str_replace(array('\','"',"\n"),array('\\','\\"','\n'),$x);$o.="msgid \"$e\"\nmsgstr \"\"\n\n";}
file_put_contents($dir.'/languages/epro-classic.pot',$o);echo "pot: ".count($s)." strings\n";
