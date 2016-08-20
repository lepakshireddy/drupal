<?php

/**
 * @file
 * Templates.
 */
global $theme, $base_url;
$theme_path = drupal_get_path('theme', $theme);
$product_tid = get_taxonomy_resource_id('Products');
  $nodes_products = taxonomy_get_children($product_tid);
  foreach ($nodes_products as $prod) {$products[$prod->tid] = $prod->name;
  }

  $resource_type_tid = get_taxonomy_resource_id('Resource type');
  $resource_type_list = taxonomy_get_children($resource_type_tid);
  $resource_name = array(
    'Patient Booklet' => 'booklet',
    'Patient Information sheet' => 'sheet',
    'Patient Website' => 'website',
    'video' => 'video',
    'Other' => 'other',
    'Patient app' => 'app',
  );
  foreach ($resource_type_list as $resource_type_val) {$resource_types[$resource_type_val->tid] = $resource_name[$resource_type_val->name];
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
</head>
<body marginheight="0" topmargin="0" marginwidth="0"  bgcolor="#FFFFFF" leftmargin="0">
    <style type="text/css">
    a { color: white !important; text-decoration: none !important; }
    a:hover { color: white !important; text-decoration: underline !important; }
  table, tbody, td, tr, div, p {font-family: Arial, sans-serif;}
</style>
<div style="margin: 0px; font-family: Arial, sans-serif; font-size: 13px; line-height: 1.5; background-color: #e7e7e7;" bgcolor="#e7e7e7">
<table cellspacing="0" border="0" cellpadding="0" width="100%" style="font-family: Arial, sans-serif;">
    <tr>
        <td>
<table align="center" width="600" cellspacing="0" cellpadding="0" border="0" style="border: 1px solid #cccccc;">
            <tbody><tr>
                <td>
<?php print variable_get('jjfusion_ap_hcp_patient_resource_email_body_header', '');?>            
<table width="600" cellspacing="0" cellpadding="25" border="0" bgcolor="#ffffff">
    <tbody>
        <tr>
            <td style="padding-bottom: 0;">
                <?php
               $secret_keys = preg_split('/\n+/', variable_get('jjfusion_ap_hcp_patient_resource_secret_keys', ''));
                  $secret_key = array_rand($secret_keys, 1); ?>
                <?php print variable_get('jjfusion_ap_hcp_patient_resource_header', '');?>
                <p style="margin:20px 0;"><?php print t('Some content is password protected. Access these resources using the password:');?><b><?php print trim($secret_keys[$secret_key]);?></b></p>
            </td>
        </tr>
    </tbody>
</table>
<!--only products -->
<?php if($product_data){$product_total_results = 0; ?>
    <table width="600" cellspacing="0" cellpadding="25" border="0" bgcolor="#ffffff">
        <tbody>
            <tr>
                <td >
                    <?php print variable_get('jjfusion_ap_hcp_patient_resource_product_info', ''); ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
    foreach($product_data as $key => $data_title){$p_res_count = 0;
       $product = taxonomy_term_load($product_data[$key]['pid']);
       $produtrelated_patient_resource = array();
      foreach($resources as $resource){if(isset($resource->field_general_tags[LANGUAGE_NONE]) && array_search($product_data[$key]['pid'], array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {$p_res_count = $p_res_count + 1;
         $produtrelated_patient_resource[] = $resource;
      }
      }

            if($p_res_count){$product_total_results++;?>
            <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#019cdc">
                <tbody>
                    <tr>
                        <td style="padding: 10px 25px;font-size: 22px; font-weight: bold; color: #ffffff; border-top: 5px solid white; border-bottom: 1px solid #a6cbd1;">
                                <?php print $product->name . ' patient resources';?>
                        </td>
                    </tr>
                </tbody>
          </table>
          <table width="600" cellspacing="0" cellpadding="25" border="0" bgcolor="#019cdc">
            <tbody>
                <?php
                foreach($produtrelated_patient_resource as $patient_resource) {$res_type_name = '';
          foreach($resource_types as $res_key => $res_val) {if (array_search($res_key, array_column($patient_resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){$res_type_name = $res_val;
          }
          }
          ?>
                    <tr>
                        <td style="padding: 0;">
                            <table width="550" cellspacing="0" cellpadding="0" border="0" style="padding: 0 20px; color: #ffffff;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table cellspacing="0" cellpadding="15" border="0" style="border-bottom: 1px solid #a6cbd1;">
                                                <tbody>
                                                    <tr>
                                                        <td width="30" valign="top">
                                                            <img src="<?php print $base_url . '/' . $theme_path . '/css/images/icon_' . trim($res_type_name) . '.png'?>">
                                                        </td>
                                                        <td valign="top">
                                                            <div style="font-weight: bold;"><?php print check_plain($patient_resource->title);?></div>
                                                            <div><?php print strip_tags($patient_resource->body[LANGUAGE_NONE][0]['value']);?></div>
                                                        </td>
                                                        <td valign="top">
                                <?php
                                $path = '';
                                if(strpos($patient_resource->field_resource_file[LANGUAGE_NONE][0]['filename'], 'dummy') === FALSE) {$url = $base_url . str_replace('public://', '/resources/files/', $patient_resource->field_resource_file[LANGUAGE_NONE][0]['uri']);
                                }elseif($patient_resource->body[LANGUAGE_NONE][0]['summary'] != '' && trim($res_type_name) != 'video'){$url = trim(strip_tags($patient_resource->body[LANGUAGE_NONE][0]['summary']));
                                }elseif(trim($res_type_name) == 'video') {$url = $base_url . '/patient-resource-video/' . $patient_resource->nid . '/video';
                                }?>
                                                            <a href="<?php print $url;?>"><img height="12" src="<?php print $base_url . '/' . $theme_path . '/css/images/arrow.png'?>"></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php
                } ?>
          </tbody>
        </table>
    <?php
            }
    }
}
?>
<!--only conditions -->
<?php if($cond_data){$total_results = 0; ?>
    <table width="600" cellspacing="0" cellpadding="25" border="0" bgcolor="#ffffff">
        <tbody>
            <tr>
                <td style="padding:0 25px 25px;"><?php print variable_get('jjfusion_ap_hcp_patient_resource_condition_info', ''); ?></td>
            </tr>
        </tbody>
    </table>
<?php foreach($cond_data as $key => $cond_data_title){$res_count = 0;
      $condition_html = '';
      $condition = taxonomy_term_load($cond_data[$key]['cid']);
      $condition_patient_resource = array();
      foreach($resources as $resource){if(isset($resource->field_general_tags[LANGUAGE_NONE]) && array_search($cond_data[$key]['cid'], array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {$pro_flag = TRUE;
          foreach($products as $pro_key => $prod_name){if(array_search($pro_key, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){$pro_flag = FALSE;
          }
          }
          if($pro_flag) {$res_count = $res_count + 1;
            $condition_patient_resource[] = $resource;
          }
      }
      }
    if($res_count) {$total_results++;?>
        <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#019cdc">
            <tbody>
                <tr>
                    <td  style="padding: 10px 25px;font-size: 22px; font-weight: bold; color: #ffffff; border-top: 5px solid white; border-bottom: 1px solid #a6cbd1;"><?php print $condition->name . ' patient resources';?></td>
                </tr>
            </tbody>
        </table>
        <table width="600" cellspacing="0" cellpadding="25" border="0" bgcolor="#019cdc">
            <tbody>
            <?php
            foreach($condition_patient_resource as $patient_resource) {$res_type_name = '';
              foreach($resource_types as $res_key => $res_val) {if (array_search($res_key, array_column($patient_resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){$res_type_name = $res_val;
              }
              }
          ?>
            <tr>
                <td style="padding: 0;">
                    <table width="550" cellspacing="0" cellpadding="0" border="0" style="padding: 0 20px; color: #ffffff;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table cellspacing="0" cellpadding="15" border="0" style="border-bottom: 1px solid #a6cbd1;">
                                                <tbody>
                                                    <tr>
                                                        <td width="30" valign="top">
                                                            <img src="<?php print $base_url . '/' . $theme_path . '/css/images/icon_' . trim($res_type_name) . '.png'?>">
                                                        </td>
                                                        <td valign="top">
                                                            <div style="font-weight: bold;"><?php print $patient_resource->title;?></div>
                                                            <div><?php print strip_tags($patient_resource->body[LANGUAGE_NONE][0]['value']);?></div>
                                                        </td>
                                                        <td valign="top">
                                <?php
                                $path = '';
                                if(strpos($patient_resource->field_resource_file[LANGUAGE_NONE][0]['filename'], 'dummy') === FALSE) {$url = $base_url . str_replace('public://', '/resources/files/', $patient_resource->field_resource_file[LANGUAGE_NONE][0]['uri']);
                                }elseif($patient_resource->body[LANGUAGE_NONE][0]['summary'] != '' && trim($res_type_name) != 'video'){$url = trim(strip_tags($patient_resource->body[LANGUAGE_NONE][0]['summary']));
                                }elseif(trim($res_type_name) == 'video') {$url = $base_url . '/patient-resource-video/' . $patient_resource->nid . '/video';
                                }?>
                                                            <a href="<?php print $url;?>"><img height="12" src="<?php print $base_url . '/' . $theme_path . '/css/images/arrow.png'?>"></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                </td>
            </tr>
            <?php
            } ?>
            </tbody>
</table>
 <?php
    }
}
}
?>
<!--both products and conditions -->
<?php if($pro_con_data){$pro_con_total_results = 0;
  $total_results = 0;?>
<table width="600" cellspacing="0" cellpadding="25" border="0" bgcolor="#ffffff">
                        <tbody><tr>
                            <td  style="padding:0 25px 25px;">
                                <?php print variable_get('jjfusion_ap_hcp_patient_resource_condition_info', ''); ?>
                            </td>
                        </tr>
                    </tbody>
          </table>

<?php
        foreach($con_id as $key => $con_id_title){$res_count = 0;
      $con_html = '';
      $condition = taxonomy_term_load($con_id[$key]['cid']);
      $condition_patient_resource = array();
      foreach($resources as $resource){if(isset($resource->field_general_tags[LANGUAGE_NONE]) && array_search($con_id[$key]['cid'], array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {$pro_flag = TRUE;
          foreach($products as $pro_key => $prod_name){if(array_search($pro_key, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){$pro_flag = FALSE;
          }
          }
          if($pro_flag) {$res_count = $res_count + 1;
           $condition_patient_resource[] = $resource;
          }
      }
      }
            if($res_count) {$total_results++;?>
                <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#019cdc">
                        <tbody><tr>
                            <td  style="padding: 10px 25px;font-size: 22px; font-weight: bold; color: #ffffff; border-top: 5px solid white; border-bottom: 1px solid #a6cbd1;">
                                <?php print $condition->name . ' patient resources';?>
                            </td>
                        </tr>
                    </tbody>
          </table>
          <table width="600" cellspacing="0" cellpadding="25" border="0" bgcolor="#019cdc">
                        <tbody>
            <?php
            foreach($condition_patient_resource as $patient_resource) {$res_type_name = '';
              foreach($resource_types as $res_key => $res_val) {if (array_search($res_key, array_column($patient_resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){$res_type_name = $res_val;
              }
              }?>
             <tr>
                            <td style="padding: 0;">
                                <table width="550" cellspacing="0" cellpadding="0" border="0" style="padding: 0 20px; color: #ffffff;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table cellspacing="0" cellpadding="15" border="0" style="border-bottom: 1px solid #a6cbd1;">
                                                <tbody>
                                                    <tr>
                                                        <td width="30" valign="top">
                                                            <img src="<?php print $base_url . '/' . $theme_path . '/css/images/icon_' . trim($res_type_name) . '.png'?>">
                                                        </td>
                                                        <td valign="top">
                                                            <div style="font-weight: bold;"><?php print $patient_resource->title;?></div>
                                                            <div><?php print strip_tags($patient_resource->body[LANGUAGE_NONE][0]['value']);?></div>
                                                        </td>
                                                        <td valign="top">
                                <?php
                                $path = '';
                                if(strpos($patient_resource->field_resource_file[LANGUAGE_NONE][0]['filename'], 'dummy') === FALSE) {$url = $base_url . str_replace('public://', '/resources/files/', $patient_resource->field_resource_file[LANGUAGE_NONE][0]['uri']);
                                }elseif($patient_resource->body[LANGUAGE_NONE][0]['summary'] != '' && trim($res_type_name) != 'video'){$url = trim(strip_tags($patient_resource->body[LANGUAGE_NONE][0]['summary']));
                                }elseif(trim($res_type_name) == 'video') {$url = $base_url . '/patient-resource-video/' . $patient_resource->nid . '/video';
                                }?>
                                                            <a href="<?php print $url;?>"><img height="12" src="<?php print $base_url . '/' . $theme_path . '/css/images/arrow.png'?>"></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </td>
                        </tr>
            <?php
            } ?>
          </tbody>
          </table>
      
<?php
            }
        }?>
      
      
<table width="600" cellspacing="0" cellpadding="25" border="0" bgcolor="#ffffff">
                        <tbody><tr>
                            <td>
                                <?php print variable_get('jjfusion_ap_hcp_patient_resource_product_info', ''); ?>
                            </td>
                        </tr>
                    </tbody>
          </table>
<?php
foreach($pro_con_data as $key => $pc_data_title){$pro_con_res_count = 0;
      $prod_patient_count = 0;
      $pro_con_html = '';
      $pro_con_patient_resource = array();
      $product = taxonomy_term_load($pro_con_data[$key]['pid']);
      foreach($resources as $resource){if(isset($resource->field_general_tags[LANGUAGE_NONE]) && array_search($pro_con_data[$key]['pid'], array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {$con_flag = FALSE;
          foreach($con_id as $con_key => $con_title){if(array_search($con_id[$con_key]['cid'], array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){$con_flag = TRUE;
          }
          }
          if($con_flag){$prod_patient_count = $prod_patient_count + 1;
            $pro_con_patient_resource[] = $resource;
          }
      }
      }
    if($prod_patient_count) {$pro_con_total_results++;?>
      <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#019cdc">
                        <tbody><tr>
                            <td style="padding: 10px 25px;font-size: 22px; font-weight: bold; color: #ffffff; border-top: 5px solid white; border-bottom: 1px solid #a6cbd1;">
                    <?php print $product->name . ' patient resources';?>
                            </td>
                        </tr>
                    </tbody>
          </table>          
          <table width="600" cellspacing="0" cellpadding="25" border="0" bgcolor="#019cdc">
                        <tbody>
            <?php
            foreach($pro_con_patient_resource as $patient_resource) {$res_type_name = '';
              foreach($resource_types as $res_key => $res_val) {if (array_search($res_key, array_column($patient_resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){$res_type_name = $res_val;
              }
              }
              ?>
             <tr>
                            <td style="padding: 0;">
                                <table width="550" cellspacing="0" cellpadding="0" border="0" style="padding: 0 20px; color: #ffffff;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table cellspacing="0" cellpadding="15" border="0" style="border-bottom: 1px solid #a6cbd1;">
                                                <tbody>
                                                    <tr>
                                                        <td width="30" valign="top">
                                                            <img src="<?php print $base_url . '/' . $theme_path . '/css/images/icon_' . trim($res_type_name) . '.png'?>">
                                                        </td>
                                                        <td valign="top">
                                                            <div style="font-weight: bold;"><?php print $patient_resource->title;?></div>
                                                            <div><?php print strip_tags($patient_resource->body[LANGUAGE_NONE][0]['value']);?></div>
                                                        </td>
                                                        <td valign="top">
                                <?php
                                $path = '';
                                if(strpos($patient_resource->field_resource_file[LANGUAGE_NONE][0]['filename'], 'dummy') === FALSE) {$url = $base_url . str_replace('public://', '/resources/files/', $patient_resource->field_resource_file[LANGUAGE_NONE][0]['uri']);
                                }elseif($patient_resource->body[LANGUAGE_NONE][0]['summary'] != '' && trim($res_type_name) != 'video'){$url = trim(strip_tags($patient_resource->body[LANGUAGE_NONE][0]['summary']));
                                }elseif(trim($res_type_name) == 'video') {$url = $base_url . '/patient-resource-video/' . $patient_resource->nid . '/video';
                                }?>
                                                            <a href="<?php print $url;?>"><img height="12" src="<?php print $base_url . '/' . $theme_path . '/css/images/arrow.png'?>"></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </td>
                        </tr>
            <?php
            } ?>
          </tbody>
          </table>
    <?php
    } else {$p_res_count = 0;
    $pro_related_html = '';
        $product = taxonomy_term_load($pro_con_data[$key]['pid']);
       $produtrelated_patient_resource = array();
      foreach($resources as $resource){if(isset($resource->field_general_tags[LANGUAGE_NONE]) && array_search($pro_con_data[$key]['pid'], array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {$p_res_count = $p_res_count + 1;
         $produtrelated_patient_resource[] = $resource;
      }
      }

            if($p_res_count){$pro_con_res_count++;?>
            <table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#019cdc">
                <tbody>
                    <tr>
                        <td style="padding: 10px 25px;font-size: 22px; font-weight: bold; color: #ffffff; border-top: 5px solid white; border-bottom: 1px solid #a6cbd1;">
                                <?php print $product->name . ' patient resources';?>
                        </td>
                    </tr>
                </tbody>
          </table>
          <table width="600" cellspacing="0" cellpadding="25" border="0" bgcolor="#019cdc">
            <tbody>
                <?php
                foreach($produtrelated_patient_resource as $patient_resource) {$res_type_name = '';
          foreach($resource_types as $res_key => $res_val) {if (array_search($res_key, array_column($patient_resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){$res_type_name = $res_val;
          }
          }
          ?>
                    <tr>
                        <td style="padding: 0;">
                            <table width="550" cellspacing="0" cellpadding="0" border="0" style="padding: 0 20px; color: #ffffff;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table cellspacing="0" cellpadding="15" border="0" style="border-bottom: 1px solid #a6cbd1;">
                                                <tbody>
                                                    <tr>
                                                        <td width="30" valign="top">
                                                            <img src="<?php print $base_url . '/' . $theme_path . '/css/images/icon_' . trim($res_type_name) . '.png'?>">
                                                        </td>
                                                        <td valign="top">
                                                            <div style="font-weight: bold;"><?php print $patient_resource->title;?></div>
                                                            <div><?php print strip_tags($patient_resource->body[LANGUAGE_NONE][0]['value']);?></div>
                                                        </td>
                                                        <td valign="top">
                                <?php
                                $path = '';
                                if(strpos($patient_resource->field_resource_file[LANGUAGE_NONE][0]['filename'], 'dummy') === FALSE) {$url = $base_url . str_replace('public://', '/resources/files/', $patient_resource->field_resource_file[LANGUAGE_NONE][0]['uri']);
                                }elseif($patient_resource->body[LANGUAGE_NONE][0]['summary'] != '' && trim($res_type_name) != 'video'){$url = trim(strip_tags($patient_resource->body[LANGUAGE_NONE][0]['summary']));
                                }elseif(trim($res_type_name) == 'video') {$url = $base_url . '/patient-resource-video/' . $patient_resource->nid . '/video';
                                }?>
                                                            <a href="<?php print $url;?>"><img height="12" src="<?php print $base_url . '/' . $theme_path . '/css/images/arrow.png'?>"></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php
                } ?>
          </tbody>
        </table>
    <?php
            }?>
 <?php
    }
}
}?>
</td>
    </tr>
    </table>     
     <?php print variable_get('jjfusion_ap_hcp_patient_resource_email_footer', '');?>   
</td>
    </tr>
    </table>
</div>
</body>
</html>
