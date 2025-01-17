<?php
namespace UserMeta\AuthorBox;

use UserMeta\Html\Html;

global $userMeta;
Base::enqueScript('authorbox.js');
?>

<div>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="nav-item"><a href="#um_addon_author_box_choose_field" class="nav-link active"
			aria-controls="um_addon_author_box_choose_field" role="tab" data-bs-toggle="tab">Author Fields</a></li>
		<li role="presentation" class="nav-item"><a href="#um_addon_author_box_settings" class="nav-link" aria-controls="um_addon_author_box_settings"
			role="tab" data-bs-toggle="tab">Box Settings</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="um_addon_author_box_choose_field">
            <br>
            <div><p><i><?php _e('Assign Field (from Shared Fields) to each Author Box Fields',$userMeta->name); ?></i></p></div>
            <p>
                <?php echo Html::select(isset($data['description']) ? $data['description'] : '', [
                    'name' => 'description',
                    'label' => [
                        __('Author Description Field', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                ], $fields); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['designation']) ? $data['designation'] : '', [
                    'name' => 'designation',
                    'label' => [
                        __('Author Designation Field', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                ], $fields); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['show_email']) ? $data['show_email'] : 'no', [
                    'name' => 'show_email',
                    'label' => [
                        __('Show Email Address', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                ], $choice); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['show_contact_no']) ? $data['show_contact_no'] : 'no', [
                    'name' => 'show_contact_no',
                    'label' => [
                        __('Show Contact No', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                    'onchange' => "umHideShowAuthorBoxField( 'show_contact_no', {
                        yes : '#um_addon_author_box_contact_no'    
                    } )"
                ], $choice); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['contact_no']) ? $data['contact_no'] : '', [
                    'name' => 'contact_no',
                    'label' => [
                        __('Contact No. Field', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                    'id' => 'um_addon_author_box_contact_no',
                ], $fields); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['show_portfolio']) ? $data['show_portfolio'] : 'yes', [
                    'name' => 'show_portfolio',
                    'label' => [
                        __('Show Portfolio Link', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                    'onchange' => "umHideShowAuthorBoxField( 'show_portfolio', {
                        yes : '#um_addon_author_box_portfolio'    
                    } )"
                ], $choice); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['portfolio']) ? $data['portfolio'] : '', [
                    'name' => 'portfolio',
                    'label' => [
                        __('Portfolio URL Field', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                    'id' => 'um_addon_author_box_portfolio',
                ], $fields); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['show_facebook']) ? $data['show_facebook'] : 'yes', [
                    'name' => 'show_facebook',
                    'label' => [
                        __('Show Facebook Link', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                    'onchange' => "umHideShowAuthorBoxField( 'show_facebook', {
                        yes : '#um_addon_author_box_facebook'    
                    } )"
                ], $choice); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['facebook']) ? $data['facebook'] : '', [
                    'name' => 'facebook',
                    'label' => [
                        __('Facebook Profile URL Field', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                    'id' => 'um_addon_author_box_facebook',
                ], $fields); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['show_linkedin']) ? $data['show_linkedin'] : 'yes', [
                    'name' => 'show_linkedin',
                    'label' => [
                        __('Show LinkedIn Link', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                    'onchange' => "umHideShowAuthorBoxField( 'show_linkedin', {
                        yes : '#um_addon_author_box_linkedin'    
                    } )"
                ], $choice); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['linkedin']) ? $data['linkedin'] : '', [
                    'name' => 'linkedin',
                    'label' => [
                        __('LinkedIn Profile URL Field', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                    'id' => 'um_addon_author_box_linkedin',
                ], $fields); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['show_twitter']) ? $data['show_twitter'] : 'yes', [
                    'name' => 'show_twitter',
                    'label' => [
                        __('Show Twitter Link', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                    'onchange' => "umHideShowAuthorBoxField( 'show_twitter', {
                        yes : '#um_addon_author_box_twitter'    
                    } )"
                ], $choice); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['twitter']) ? $data['twitter'] : '', [
                    'name' => 'twitter',
                    'label' => [
                        __('Twitter Profile URL Field', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                    'id' => 'um_addon_author_box_twitter',
                ], $fields); ?>
            </p>

        </div>
		<div role="tabpanel" class="tab-pane" id="um_addon_author_box_settings">
            <br>
            <p>
                <?php echo Html::select(isset($data['theme']) ? $data['theme'] : 'plain', [
                    'name' => 'theme',
                    'label' => [
                        __('Author Box Theme', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                ], $theme); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['position']) ? $data['position'] : 'after', [
                    'name' => 'position',
                    'label' => [
                        __('Author Box Position', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                ], $position); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['set_posts']) ? $data['set_posts'] : 'yes', [
                    'name' => 'set_posts',
                    'label' => [
                        __('Show Author Box in Posts', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                ], $choice); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['set_pages']) ? $data['set_pages'] : 'no', [
                    'name' => 'set_pages',
                    'label' => [
                        __('Show Author Box in Pages', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                ], $choice); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['name_type']) ? $data['name_type'] : 'display_name', [
                    'name' => 'name_type',
                    'label' => [
                        __('Author Name Type', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                ], $name_type); ?>
            </p>
            <p>
                <?php echo Html::select(isset($data['show_recent_post']) ? $data['show_recent_post'] : 'yes', [
                    'name' => 'show_recent_post',
                    'label' => [
                        __('Show Recent Posts', 'user-meta'),
                        'class' => 'col-md-5',
                    ],
                ], $choice); ?>
            </p>
        </div>
	</div>
</div>
