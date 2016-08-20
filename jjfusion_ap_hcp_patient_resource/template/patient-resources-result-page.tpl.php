<?php

/**
 * @file
 * Templates.
 */
global $theme;
  $product_tid = get_taxonomy_resource_id('Products');
  $nodes_products = taxonomy_get_children($product_tid);
  foreach ($nodes_products as $prod) {
    $products[$prod->tid] = $prod->name;
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
  foreach ($resource_type_list as $resource_type_val) {
    $resource_types[$resource_type_val->tid] = $resource_name[$resource_type_val->name];
  }
  $internal_tid = get_taxonomy_resource_id('Internal');
  $external_tid = taxonomy_get_term_by_name('External');
?>
<header class="tall" style="background-image:url(<?php  print '/' . drupal_get_path('theme', $theme)?>/images/header_resources.jpg)">
    <h1><?php print t('Patient Resources');?></h1>
</header>
<div class="patient-resources patient-resources-details">
    <div class="action">
        <h1><?php print t('Here are the available patient resources, based on your selections.');?></h1>
        <h2><?php print t('Please review the patient resources prior to emailing to ensure they are appropriate for your patient.');?></h2>
        <div class="controls">
            <a class="btn reset-btn" href="/patient-resources"><?php print t('Reset');?></a>
            <a class="btn print-btn" href="javascript:window.print();" disabled="<?php ($p_res_count > 0 ? TRUE : FALSE) ?>"><?php print t('Print');?></a>
            <a class="btn email-btn" href="#"><?php print t('Email');?></a>
        </div>
    </div>

    <?php
    // p(variable_get('jjfusion_ap_hcp_patient_resource_secret_keys', ''));.
   $secret_keys = preg_split('/\n+/', variable_get('jjfusion_ap_hcp_patient_resource_secret_keys', ''));
                  $secret_key = array_rand($secret_keys, 1);            ?>
          <div class="patient-secret-key">
              <?php print variable_get('jjfusion_ap_hcp_patient_resource_header', '');?>
          </div>
          <div class="patient-secret-key">
              <?php print t('Some content is password protected. Access these resources using the password:');?> <b><?php print $secret_keys[$secret_key];?></b>
          </div>
<!--only products -->
    <?php if($product_data){
        $product_total_results = 0;
         ?>
        <section>
            <article>
                <div class="content product_copy">
                    <?php print variable_get('jjfusion_ap_hcp_patient_resource_products_generic_products', ''); ?>
                </div>
            </article>
        </section>    <?php
        foreach($product_data as $key => $data_title){
       $p_res_count = 0;
       $product = taxonomy_term_load($product_data[$key]['pid']);
       $product_html = '';
      foreach($resources as $resource){
        if(isset($resource->field_general_tags[LANGUAGE_NONE]) && array_search($product_data[$key]['pid'], array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
          $p_res_count = $p_res_count + 1;
          $path = '';
          if(strpos($resource->field_resource_file[LANGUAGE_NONE][0]['filename'], 'dummy') === FALSE) {
            $url = file_create_url($resource->field_resource_file[LANGUAGE_NONE][0]['uri']);
            $url = parse_url($url);
            $path = $url['path'];
          }elseif($resource->body[LANGUAGE_NONE][0]['summary'] != '') {
            $path = trim(strip_tags($resource->body[LANGUAGE_NONE][0]['summary']));
          }
          $res_type_name = '';
          foreach($resource_types as $res_key => $res_val) {
            if (array_search($res_key, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){
              $res_type_name = $res_val;
            }
          }
          $internal_external = '';
          if(array_search($internal_tid, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
            $internal_external = 'Internal';
          }elseif(array_search($external_tid, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
            $internal_external = 'External';
          }
         $product_html .= '<li class="' . $res_type_name . '"><a href="' . $path . '"  class="' . $internal_external . '" target="_blank" data-vid="' . ($res_type_name == 'video' ? $resource->nid : '') . '">
 <div class="resource-title">' . $resource->title . '</div>
                  <div class="resource-info">' . strip_tags($resource->body[LANGUAGE_NONE][0]['value']) . '</div>
<div class="patient-secret-key" data-vid="' . ($res_type_name == 'video' ? $resource->nid : '') . '" data-nid="' . $resource->nid . '">' . $path . '</div>
</a></li>';
        }
      }

            if($p_res_count){
                $product_total_results++;?>
                <section>
                    <aside>
              <div class="related-patient-resources">
              <h3 class="blue">Related patient resources</h3>
              <p><?php print $product->name;?> patient resources</p>
              <ul>
                        <?php print $product_html;?>
              </ul>
              </div>
                    </aside>
                </section>
                <?php
            }
        }
         if($product_total_results == 0){?>
            <h3 class="no_res blue"><?php print t('No Results for the search criterias');?></h3>
            <?php
         }
    }
    ?>
<!--only conditions -->
    <?php if($cond_data){
        $total_results = 0;

        ?>
        <section>
            <article>
                <div class="content cond_copy">
                    <?php print variable_get('jjfusion_ap_hcp_patient_resource_products_generic_condition', ''); ?>
                </div>
            </article>
        </section> <?php
        foreach($cond_data as $key => $cond_data_title){
      $res_count = 0;
      $condition_html = '';
      $condition = taxonomy_term_load($cond_data[$key]['cid']);
      foreach($resources as $resource){
        if(isset($resource->field_general_tags[LANGUAGE_NONE]) && array_search($cond_data[$key]['cid'], array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
          $pro_flag = TRUE;
          foreach($products as $pro_key => $prod_name){
            if(array_search($pro_key, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){
              $pro_flag = FALSE;
            }
          }
          if($pro_flag) {
          $res_count = $res_count + 1;
          $path = '';
          if(strpos($resource->field_resource_file[LANGUAGE_NONE][0]['filename'], 'dummy') === FALSE) {
            $url = file_create_url($resource->field_resource_file[LANGUAGE_NONE][0]['uri']);
            $url = parse_url($url);
            $path = $url['path'];
          }elseif($resource->body[LANGUAGE_NONE][0]['summary'] != '') {
            $path = trim(strip_tags($resource->body[LANGUAGE_NONE][0]['summary']));
          }
          $res_type_name = '';
          foreach($resource_types as $res_key => $res_val) {
            if (array_search($res_key, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){
              $res_type_name = $res_val;
            }
          }
          $internal_external = '';
          if(array_search($internal_tid, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
            $internal_external = 'Internal';
          }elseif(array_search($external_tid, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
            $internal_external = 'External';
          }
         $condition_html .= '<li class="' . $res_type_name . '"><a href="' . $path . '"  class="' . $internal_external . '" target="_blank" data-vid="' . ($res_type_name == 'video' ? $resource->nid : '') . '">
 <div class="resource-title">' . $resource->title . '</div>
                  <div class="resource-info">' . strip_tags($resource->body[LANGUAGE_NONE][0]['value']) . '</div>
<div class="patient-secret-key" data-vid="' . ($res_type_name == 'video' ? $resource->nid : '') . '" data-nid="' . $resource->nid . '">' . $path . '</div>
</a></li>';
          }
        }
      }

            if($res_count) {
                $total_results++;?>
                <section>
                    <aside>
                        <div class="related-patient-resources">
              <h3 class="blue">Related patient resources</h3>
              <p><?php print $condition->name;?> patient resources</p>
              <ul>
                        <?php print $condition_html;?>
              </ul>
              </div>
                    </aside>
                </section>
            <?php }
        }
         if($total_results == 0){?>
            <h3 class="no_res blue"><?php print t('No Results for the search criteria');?></h3>
            <?php
         }
    }?>
<!--both products and conditions -->
    <?php if($pro_con_data){
        $pro_con_total_results = 0;
        /*Conditions*/
        $total_results = 0;


        ?>
        <section>
            <article>
                <div class="content cond_copy">
                    <?php print variable_get('jjfusion_ap_hcp_patient_resource_products_generic_condition', ''); ?>
                </div>
            </article>
        </section>
        <?php
        foreach($con_id as $key => $con_id_title){
            $res_count = 0;
      $con_html = '';
      $condition = taxonomy_term_load($con_id[$key]['cid']);
      foreach($resources as $resource){
        if(isset($resource->field_general_tags[LANGUAGE_NONE]) && array_search($con_id[$key]['cid'], array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
          $pro_flag = TRUE;
          foreach($products as $pro_key => $prod_name){
            if(array_search($pro_key, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){
              $pro_flag = FALSE;
            }
          }
          if($pro_flag) {
            $res_count = $res_count + 1;
            $path = '';
            if(strpos($resource->field_resource_file[LANGUAGE_NONE][0]['filename'], 'dummy') === FALSE) {
              $url = file_create_url($resource->field_resource_file[LANGUAGE_NONE][0]['uri']);
              $url = parse_url($url);
              $path = $url['path'];
            }elseif($resource->body[LANGUAGE_NONE][0]['summary'] != '') {
              $path = trim(strip_tags($resource->body[LANGUAGE_NONE][0]['summary']));
            }
            $res_type_name = '';
          foreach($resource_types as $res_key => $res_val) {
            if (array_search($res_key, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){
              $res_type_name = $res_val;
            }
          }
          $internal_external = '';
          if(array_search($internal_tid, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
            $internal_external = 'Internal';
          }elseif(array_search($external_tid, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
            $internal_external = 'External';
          }
           $con_html .= '<li class="' . $res_type_name . '"><a href="' . $path . '"  class="' . $internal_external . '" target="_blank" data-vid="' . ($res_type_name == 'video' ? $resource->nid : '') . '">
   <div class="resource-title">' . $resource->title . '</div>
                    <div class="resource-info">' . strip_tags($resource->body[LANGUAGE_NONE][0]['value']) . '</div>
  <div class="patient-secret-key" data-vid="' . ($res_type_name == 'video' ? $resource->nid : '') . '" data-nid="' . $resource->nid . '">' . $path . '</div>
  </a></li>';
          }
        }
      }
            if($res_count) {
                $total_results++;?>
                <section>
                    <aside>
                        <div class="related-patient-resources">
              <h3 class="blue">Related patient resources</h3>
              <p><?php print $condition->name;?> patient resources</p>
              <ul>
                        <?php print $con_html;?>
              </ul>
              </div>
                    </aside>
                </section>
            <?php }
        }?>
        <?php
        foreach($pro_con_data as $key => $pc_data_title){
      $pro_con_res_count = 0;
      $prod_patient_count = 0;
      $pro_con_html = '';
      $product = taxonomy_term_load($pro_con_data[$key]['pid']);
      foreach($resources as $resource){
        if(isset($resource->field_general_tags[LANGUAGE_NONE]) && array_search($pro_con_data[$key]['pid'], array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
          $con_flag = FALSE;
          foreach($con_id as $con_key => $con_title){
            if(array_search($con_id[$con_key]['cid'], array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){
              $con_flag = TRUE;
            }
          }
          if($con_flag){
            $prod_patient_count = $prod_patient_count + 1;
            $path = '';
            if(strpos($resource->field_resource_file[LANGUAGE_NONE][0]['filename'], 'dummy') === FALSE) {
              $url = file_create_url($resource->field_resource_file[LANGUAGE_NONE][0]['uri']);
              $url = parse_url($url);
              $path = $url['path'];
            }elseif($resource->body[LANGUAGE_NONE][0]['summary'] != '') {
              $path = trim(strip_tags($resource->body[LANGUAGE_NONE][0]['summary']));
            }
            $res_type_name = '';
          foreach($resource_types as $res_key => $res_val) {
            if (array_search($res_key, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){
              $res_type_name = $res_val;
            }
          }
          $internal_external = '';
          if(array_search($internal_tid, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
            $internal_external = 'Internal';
          }elseif(array_search($external_tid, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
            $internal_external = 'External';
          }
           $pro_con_html .= '<li class="' . $res_type_name . '"><a href="' . $path . '"  class="' . $internal_external . '" target="_blank" data-vid="' . ($res_type_name == 'video' ? $resource->nid : '') . '">
   <div class="resource-title">' . $resource->title . '</div>
                    <div class="resource-info">' . strip_tags($resource->body[LANGUAGE_NONE][0]['value']) . '</div>
  <div class="patient-secret-key" data-vid="' . ($res_type_name == 'video' ? $resource->nid : '') . '" data-nid="' . $resource->nid . '">' . $path . '</div>
  </a></li>';
          }
        }
      }


            if($prod_patient_count) {
                $pro_con_total_results++;?>
        <section>
            <article>
                <div class="content product_copy1">
                    <?php print variable_get('jjfusion_ap_hcp_patient_resource_products_generic_products', ''); ?>
                </div>
            </article>
        </section>
                <section>
                    <aside>
                        <div class="related-patient-resources">
              <h3 class="blue">Related patient resources</h3>
              <p><?php print $product->name;?> patient resources</p>
              <ul>
                        <?php print $pro_con_html;?>
              </ul>
              </div>
                    </aside>
                </section>
                <?php
            }else {
        $pro_related_html = '';
        $product = taxonomy_term_load($pro_con_data[$key]['pid']);
      foreach($resources as $resource){
        if(isset($resource->field_general_tags[LANGUAGE_NONE]) && array_search($pro_con_data[$key]['pid'], array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
          $prod_patient_count = $prod_patient_count + 1;
          $path = '';
          if(strpos($resource->field_resource_file[LANGUAGE_NONE][0]['filename'], 'dummy') === FALSE) {
            $url = file_create_url($resource->field_resource_file[LANGUAGE_NONE][0]['uri']);
            $url = parse_url($url);
            $path = $url['path'];
          }elseif($resource->body[LANGUAGE_NONE][0]['summary'] != '') {
            $path = trim(strip_tags($resource->body[LANGUAGE_NONE][0]['summary']));
          }
          $res_type_name = '';
          foreach($resource_types as $res_key => $res_val) {
            if (array_search($res_key, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE){
              $res_type_name = $res_val;
            }
          }
          $internal_external = '';
          if(array_search($internal_tid, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
            $internal_external = 'Internal';
          }elseif(array_search($external_tid, array_column($resource->field_general_tags[LANGUAGE_NONE], 'tid')) !== FALSE) {
            $internal_external = 'External';
          }
         $pro_related_html .= '<li class="' . $res_type_name . '"><a href="' . $path . '"  class="' . $internal_external . '" target="_blank" data-vid="' . ($res_type_name == 'video' ? $resource->nid : '') . '">
 <div class="resource-title">' . $resource->title . '</div>
                  <div class="resource-info">' . strip_tags($resource->body[LANGUAGE_NONE][0]['value']) . '</div>
<div class="patient-secret-key" data-vid="' . ($res_type_name == 'video' ? $resource->nid : '') . '" data-nid="' . $resource->nid . '">' . $path . '</div>
</a></li>';
        }
      }
      if($prod_patient_count > 0) {?>    
        <section>
            <article>
                <div class="content product_copy1">
                    <?php print variable_get('jjfusion_ap_hcp_patient_resource_products_generic_products', ''); ?>
                </div>
            </article>
        </section>
                <section>
                    <aside>
                        <div class="related-patient-resources">
              <h3 class="blue">Related patient resources</h3>
              <p><?php print $product->name;?> patient resources</p>
              <ul>
                        <?php print $pro_related_html;?>
              </ul>
              </div>
                    </aside>
                </section>
      <?php }
            }
      $pro_con_res_count = $pro_con_res_count + $prod_patient_count;
        }
        $pro_con_res = $res_count + $pro_con_res_count;
          if($pro_con_res == 0){?>
            <h3 class="no_res blue"><?php print t('No Results for the search criteria');?></h3>
            <?php
          }
    }?>

<?php $total_count = $pro_con_total_results + $res_count + $product_total_results;
/* if($total_count == 0){ ?>
<h3 class="no_res blue">No Results for the search criteria</h3>
<?php
} */
?>
    <div class="action">
        <p><?php print t('You can go back and make new selections, by hitting Reset.');?></p>
        <div class="controls">
            <a class="btn reset-btn" href="/patient-resources"><?php print t('Reset');?></a>
            <a class="btn print-btn" href="javascript:window.print();"><?php print t('Print');?></a>
            <a class="btn email-btn" href="#"><?php print t('Email');?></a>
            <input id ="hidden_print_email" type="hidden" value="<?php print $total_count;?>"/>
            <input id ="hidden_condition_count" type="hidden" value="<?php print $res_count;?>"/>
            <input id ="hidden_product_count" type="hidden" value="<?php print $product_total_results;?>"/>
            <input id ="hidden_product_con_count" type="hidden" value="<?php print $pro_con_res_count;?>"/>
        </div>
    </div>
</div>
<div class="intro-text strong">
  <p><?php print t('Some resources have been produced by independent organisations.  These resources are provided for your information only. They may contain content Janssen does not endorse. Janssen is not responsible for the validity of the information on these resources. These resources may contain or link to information that is not consistent with the way medicines are used in Australia.'); ?></p>
</div>
