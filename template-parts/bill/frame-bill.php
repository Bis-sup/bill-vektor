<div class="container">
<div class="row">
<div class="col-xs-6">
<h1 class="bill-title">御請求書</h1>
<h2 class="bill-destination">
<span class="bill-destination-client">
<?php echo esc_html( get_the_title( $post->bill_client ) );?>
</span>
<span class="bill-destination-honorific">
<?php $client_honorific = esc_html( get_post_meta( $post->bill_client, 'client_honorific', true ) );
if ( $client_honorific ) {
	echo $client_honorific;
} else {
	echo '御中';
} ?>
</span>
</h2>

<p>平素は格別のご高配に賜り、誠にありがとう御座います。<br>
下記の通りご請求申し上げます。</p>

<dl class="bill-total">
<dt>合計金額</dt>
<dd>￥ <?php echo number_format( bill_total_add_tax() );?><span class="caption">(消費税含)</span></dd>
</dl>
</div>

<div class="col-xs-5 col-xs-offset-1">
<table class="bill-info-table">
<tr>
<th>請求番号</th>
<td><?php echo esc_html( $post->bill_id ); ?></td>
</tr>
<tr>
<th>発行日</th>
<td><?php the_date(); ?></td>
</tr>
<tr>
<th>お支払期日</th>
<td><?php echo esc_html( date("Y年n月j", bill_raw_date( $post->bill_limit_date) ) ); ?></td>
</tr>
</table>

<div class="bill-address-own">
<?php $options = get_option('bill-setting', Bill_Admin::options_default());?>
<h4><?php echo esc_html( $options['own-name'] );?></h4>
<div class="bill-address"><?php echo nl2br( esc_textarea($options['own-address']) );?></div>
<?php
if ( isset( $options['own-seal'] ) && $options['own-seal'] ){
	$attr = array(
		'id'    => 'bill-seal',
		'src'   => '',
		'class' => 'bill-seal',
		'alt'   => trim( strip_tags( get_post_meta( $options['own-seal'], '_wp_attachment_image_alt', true ) ) ),
	);
	echo wp_get_attachment_image( $options['own-seal'], 'medium', false, $attr );
} ?>
</div><!-- [ /.address-own ] -->

</div><!-- [ /.container ] -->


<div class="container">

<?php get_template_part('template-parts/bill/table-price');?>

<dl class="bill-remarks">
<dt>備考</dt>
<dd>
<?php
if ( $post->bill_remarks ){
	// 請求書個別の備考
	echo apply_filters('the_content', $post->bill_remarks );
} else {
	// 共通の備考
	if ( isset( $options['remarks-bill'] ) ){
		echo apply_filters('the_content', $options['remarks-bill'] );
	}
} ?>
</dd>
</dl>

<div class="bill-payee">
<table class="table table-bordered">
<tr>
<th class="active">振込口座</th>
<td >
<p class="bill-payee-text">
<?php echo nl2br( esc_textarea($options['own-payee']) );?>
</p>
<?php
if ( isset( $options['own-logo'] ) && $options['own-logo'] ){
	$attr = array(
		'id'    => 'bill-payee-logo',
		'src'   => '',
		'class' => 'bill-payee-logo',
		'alt'   => trim( strip_tags( get_post_meta( $options['own-logo'], '_wp_attachment_image_alt', true ) ) ),
	);
	echo wp_get_attachment_image( $options['own-logo'], 'medium', false, $attr );
} ?>
</td>
</tr>
</table>
</div><!-- [ /.bill-payee ] -->
</div><!-- [ /.container ] -->