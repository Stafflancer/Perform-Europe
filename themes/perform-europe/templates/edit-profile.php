<?php /* Template Name: Edit Profile */
get_header();
// global $wpdb;
// $current_user_id = get_current_user_id();
// $user_meta = get_user_meta($current_user_id);
// $user = get_user_by( 'id', $current_user_id );
?>
<style>
	.area-wd{
		width: 100% !important;
	}
	.fl-input-cust{
		width: 90% !important;
	}
	.input-cust {
	    transition: border 0.15s, box-shadow 0.15s;
	    height: 43px;
	    border-radius: 3px;
	    padding: 0px 14px;
	    border-color: #00000040;
	    font-size: 16px;
	    border: 1px solid #00000040;
	    width: 60%;
	}
	.input-cust-1 {
	    height: auto !important;
	}
	.area-cust{
		height: 90px;
	    padding: 10px 14px;
	}
	.input-cust-cond {
	    display: none;
	}
	.tb-margin {
    	margin: 30px 0px 20px 0px;
	}
	.tb-div-margin {
		padding-bottom: 50px !important;
	}
	.checkbox-cust{
		font-size: 16px;
		font-weight: 400;
		margin: 0px;
	}
   .checkbox-container {
	    display: flex;
	    flex-wrap: wrap;
		gap: 20px;
	}
	@media screen and (min-width: 640px) {
	.fl-container{
		gap: 0px !important;
		width: 63% !important;
	}
   .checkbox-group {
		flex: 1;
		}
	}
	@media screen and (max-width: 480px) {
		.input-cust {
			width: 100% !important;
		}
		.w-100{
			width: 100%;
		}
	}
	.cont-pb{
		padding-top: 15px;
		padding-bottom: 30px;
	}
	.char-count {
            font-size: 14px;
    }
	.update-btn{
	    background-color: #ff00ff;
    	border: none;
    	padding: 15px;
    	color: #ffffff;
		cursor: pointer;
	}
	.update-btn:hover{
		background-color: #111111;
	}
	.p-para{
		font-size: 14px;
		margin-bottom: 0px !important;
	}
	.para-p1{
		font-size: 14px;
		margin-bottom: 14px !important;
	}
</style>
<section class="section-wrp s-login">
    <div class="page-content-wrp">
        <div class="page__title-wrp">
            <h1 class="page__title"><?php the_title();?></h1>
        </div>
    </div>
</section>
<section class="section-wrp s-login-form">
    <div class="create-account-wrp">
        <?php // echo do_shortcode('[wpforms id="1486" title="false" description="false"]');?>
<?php 
		// Check if the user is logged in
if (is_user_logged_in()) {
    // Get the current user ID
    $user_id = get_current_user_id();

    // Check if the form is submitted for updating profile
    if (isset($_POST['update_profile'])) {
        // Update user meta fields
        update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
        update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
		update_user_meta($user_id, 'description', sanitize_text_field($_POST['description']));
		// Update ACF fields
		update_field('pronouns', sanitize_text_field($_POST['pronouns']), 'user_' . $user_id);
		update_field('cover_picture', esc_url($_POST['cover_picture']), 'user_' . $user_id);
		update_field('job_title', sanitize_text_field($_POST['job_title']), 'user_' . $user_id);
		update_field('name_of_organisation', sanitize_text_field($_POST['name_of_organisation']), 'user_' . $user_id);
		update_field('social', esc_url($_POST['social']), 'user_' . $user_id);
		update_field('city', sanitize_text_field($_POST['city']), 'user_' . $user_id);
		update_field('country', sanitize_text_field($_POST['country']), 'user_' . $user_id);
		update_field('your_offer', esc_textarea($_POST['your_offer']), 'user_' . $user_id);
		update_field('your_needs', esc_textarea($_POST['your_needs']), 'user_' . $user_id);
		update_field('all_tour', esc_textarea($_POST['all_tour']), 'user_' . $user_id);
		update_field('all_work', esc_textarea($_POST['all_work']), 'user_' . $user_id);
		$performing_art_forms = isset($_POST['performing_art_forms']) ? array_map('sanitize_text_field', $_POST['performing_art_forms']) : array();
		update_field('performing_art_forms', $performing_art_forms, 'user_' . $user_id);
		$organisation_type = isset($_POST['organisation_type']) ? array_map('sanitize_text_field', $_POST['organisation_type']) : array();
		update_field('organisation_type', $organisation_type, 'user_' . $user_id);
		$topics_covered = isset($_POST['topics_covered']) ? array_map('sanitize_text_field', $_POST['topics_covered']) : array();
	    update_field('topics_covered', $topics_covered, 'user_' . $user_id);
		$account_type_value = isset($_POST['account_type']) ? sanitize_text_field($_POST['account_type']) : '';
		update_field('account_type', $account_type_value, 'user_' . $user_id);
		$offer_work_choices = isset($_POST['i_offer_work']) ? $_POST['i_offer_work'] : array();
		update_field('i_offer_work', $offer_work_choices, 'user_' . $user_id);
		$offer_tour_values = isset($_POST['i_offer_tour']) ? $_POST['i_offer_tour'] : array();
		update_field('i_offer_tour', $offer_tour_values, 'user_' . $user_id);

        echo '<p style="color: #FF00FF;">Profile updated successfully!</p>';
    }

    // Get relevant user meta data
    $first_name = get_user_meta($user_id, 'first_name', true);
    $last_name = get_user_meta($user_id, 'last_name', true);
	$user_email = get_user_meta($user_id, 'user_email', true);
	$description = get_user_meta($user_id, 'description', true);

    // Get the ACF custom field value
    $pronouns = get_field('pronouns', 'user_' . $user_id);
	$job_title = get_field('job_title', 'user_' . $user_id);
	$name_of_organisation = get_field('name_of_organisation', 'user_' . $user_id);
	$social = get_field('social', 'user_' . $user_id);
	$cover_picture = get_field('cover_picture', 'user_' . $user_id);
	$country = get_field('country', 'user_' . $user_id);
	$city = get_field('city', 'user_' . $user_id);
	$your_offer = get_field('your_offer', 'user_' . $user_id);
	$your_needs = get_field('your_needs', 'user_' . $user_id);
	$all_work = get_field('all_work', 'user_' . $user_id);
	$all_tour = get_field('all_tour', 'user_' . $user_id);
	$performing_art_forms = get_field('performing_art_forms', 'user_' . $user_id);
	$topics_covered = get_field('topics_covered', 'user_' . $user_id);
	$account_type = get_field('account_type', 'user_' . $user_id);
	$i_offer_work = get_field('i_offer_work', 'user_' . $user_id);
	$offer_work_choices = array(
		'Performing arts work(s)' => 'Performing arts work(s)'
	);
	$account_type_choices = array(
		'Individual' => 'Individual',
		'Organisation' => 'Organisation',
	);
	$i_offer_tour = get_field('i_offer_tour', 'user_' . $user_id);
	$offer_tour_choices = array(
		'Touring opportunity(ies)' => 'Touring opportunity(ies)'
	);
	$organisation_type = get_field('organisation_type', 'user_' . $user_id);
    ?>

<form method="post" action="">
    <div class="tb-div-margin">
        <h3>Main Contact</h3>
        <p>Your main contact person will be the person receiving all the Perform Europe notifications and information. Their full name, pronouns, job title and email address will only be made public to profiles with whom you’ve had a match in the online matchmaking tool.</p>
    </div>
	<div class="checkbox-container fl-container">
  		<div class="checkbox-group">
        	<label for="first_name">First Name:</label>
        	<input type="text" name="first_name" class="input-cust fl-input-cust" value="<?php echo esc_attr($first_name); ?>" />
    	</div>
  <div class="checkbox-group">
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" class="input-cust fl-input-cust" value="<?php echo esc_attr($last_name); ?>" />
    </div>
	</div>
	<div class="tb-margin">
        <label for="pronouns">Pronouns:</label>
        <input type="text" name="pronouns" class="input-cust" value="<?php echo esc_attr($pronouns); ?>" />
    </div>
    <div class="tb-margin">
        <label for="job_title">Job Title:</label>
        <input type="text" name="job_title" class="input-cust" value="<?php echo esc_attr($job_title); ?>" />
    </div>
    <div class="tb-margin">
        <label for="user_email">Email:</label>
<!--         <input type="email" name="user_email" class="input-cust" value="<?php echo esc_attr($user_email); ?>" readonly /> -->
		<p class="para-p1">Please contact <a href="mailto:info@performeurope.eu">administrator</a> to change your email address.</p>
    </div>
    <div class="tb-margin">
        <label for="social">Website or Social media:</label>
        <input type="url" name="social" class="input-cust" value="<?php echo esc_url($social); ?>" />
    </div>
	<div class="tb-margin">
	<h3>About your organisation / independent activities</h3>
	</div>            
	<div class="tb-margin">
		<label for="cover_picture">Cover Picture:</label>
		<p class="p-para">Use your own url or an image host such as <a href='https://postimages.org/' target='blank'>https://postimages.org/</a> to upload your image and paste <b>the direct link*</b> here.<br>*A direct link ends with the image extension (eg. https://url.com/image.jpg)</p>
		<input type="url" name="cover_picture"  class="input-cust" value="<?php echo esc_url($cover_picture); ?>"/>
	</div>
			<?php if (!empty($account_type_choices)): ?>
		<div class="tb-margin">
			<label for="account_type">I am an:</label>
					<?php foreach ($account_type_choices as $value => $label): ?>
				  <label class="checkbox-cust">
						<input type="radio" name="account_type" value="<?php echo $value; ?>" <?php echo $value === $account_type ? 'checked' : ''; ?>> <?php echo $label; ?><br>
    </label>
					<?php endforeach; ?>
						</div>
			<?php endif; ?>
		    <div class="tb-margin input-cust-cond">
        <label for="name_of_organisation">Name of Organisation:</label>
        <input type="text" name="name_of_organisation" class="input-cust input-cust-cond" value="<?php echo esc_attr($name_of_organisation); ?>" />
    		</div>
			<div class="tb-margin">
				<label for="country">Country:</label>
					<select name="country" class="input-cust">
						<?php
						$countries = array(
							'Albania', 'Armenia', 'Austria', 'Belgium', 'Bosnia and Herzegovina', 'Bulgaria',
							'Croatia', 'Cyprus', 'Czech Republic', 'Denmark', 'Estonia', 'Finland', 'France',
							'Germany', 'Georgia', 'Greece', 'Hungary', 'Iceland', 'Ireland', 'Italy', 'Kosovo',
							'Latvia', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Malta', 'Montenegro', 'Netherlands',
							'North Macedonia', 'Norway', 'Poland', 'Portugal', 'Romania', 'Serbia', 'Slovakia',
							'Slovenia', 'Spain', 'Sweden', 'Tunisia', 'Ukraine'
						);

						foreach ($countries as $country_option) {
							?>
							<option class="input-cust" value="<?php echo esc_attr($country_option); ?>" <?php selected($country_option, $country); ?>>
								<?php echo esc_html($country_option); ?>
							</option>
							<?php
						}
						?>
					</select>
				</div>
			<div class="tb-margin">
                <label for="city">City / Town / Village:</label>
                <input type="text" name="city" class="input-cust" value="<?php echo esc_attr($city); ?>" />
            </div>
			<div class="tb-margin">
				<label for="description">Who are you and what are you looking for? Keep the aims and priorities of the Perform Europe open call in mind.</label>
				<p class="p-para">Example: Festival X is an outdoor circus festival based in Slovenia (...). We are looking for new partnerships, to expand our contacts, specifically to enrich the programme of our next edition with emerging artists. We want to explore new ideas to make our festival more inclusive.</p>
				<textarea name="description" id="description" class="input-cust input-cust-1 area-cust" rows="7"><?php echo esc_textarea(htmlspecialchars_decode($description)); ?></textarea>
				<div id="char-count-your-description" class="char-count"></div>
			</div>
			<div class="tb-margin">
				<label for="your_offer">Summarise in one line what you offer?</label>
				<p class="p-para">Example: a platform for circus artists and companies, both emerging and established ones, to showcase their works during our festival in Slovenia</p>
				<textarea name="your_offer" id="your_offer" class="input-cust input-cust-1 area-cust" rows="7"><?php echo esc_textarea(htmlspecialchars_decode($your_offer)); ?></textarea>
				<div id="char-count-your-offer" class="char-count"></div>
			</div>
			<div class="tb-margin">
				<label for="your_needs">Summarise in one-line what you are looking for?</label>
				<p class="p-para">Example: emerging circus artists or companies interested in the next edition of our festival, collaborations to explore new ideas to make circus arts presentations more inclusive.</p>
				<textarea name="your_needs" id="your_needs" class="input-cust input-cust-1 area-cust" rows="7"><?php echo esc_textarea(htmlspecialchars_decode($your_needs)); ?></textarea>
				<div id="char-count-your-needs" class="char-count"></div>
			</div>
<div class="tb-margin">
  <h3>Your activities</h3>
</div>

<div class="checkbox-container">
	<div class="checkbox-group">
    <?php
    // Manually define the array of terms
    $all_terms = array(
	'Performing Arts Company',
	'Festival',
	'Venue',
	'Artistic collective',
	'Artistic residency',
	'Artist',
	'Producer',
	'Production organisation',
	'Tour Manager',
	'Research professional or organisation',
	'Educational professional or organisation',
	'Non Profit Organisation , NPO',
	'Non Governmental Organisation NGO',
	'Other',
    );
    echo '<h4 style="padding-bottom: 25px; font-size: 20px; font-weight: 600;">Organisation/Individual Type:</h4>';
    foreach ($all_terms as $term) {
        $checked = in_array($term, (array)$organisation_type) ? 'checked' : '';
        echo '<label class="checkbox-cust"><input type="checkbox" name="organisation_type[]" value="' . sanitize_text_field($term) . '" ' . $checked . '> ' . $term . '</label>';
    }
    ?>
</div>
<div class="checkbox-group">
    <?php
    // Manually define the array of terms
    $all_terms = array(
        'Circus',
        'Dance',
        'Mime',
        'Music Theatre',
        'New technologies',
        'Other',
        'Performance Art',
        'Physical Theatre',
        'Playwriting',
        'Puppetry / Object Theatre',
        'Site specific work',
        'Street arts',
        'Theatre',
        'Youth Theatre'
    );
    echo '<h4 style="padding-bottom: 25px; font-size: 20px; font-weight: 600;">My performing arts form(s)</h4>';
    foreach ($all_terms as $term) {
        $checked = in_array($term, (array)$performing_art_forms) ? 'checked' : '';
        echo '<label class="checkbox-cust"><input type="checkbox" name="performing_art_forms[]" value="' . sanitize_text_field($term) . '" ' . $checked . '> ' . $term . '</label>';
    }
    ?>
</div>
	<div class="checkbox-group">
    <?php
    $all_terms = array(
    'Activism',
    'Advocacy',
    'Artistic development',
    'Artistic freedom',
    'Audience development',
    'Business models',
    'Climate justice',
    'Conflict',
    'Cross-sectoral collaboration',
    'Decolonisation',
    'Disability',
    'Diversity',
    'Education',
    'Elderly',
    'Environment',
    'Equity and Equality',
    'Feminism',
    'Freedom of expression',
    'Gender',
    'Globalisation',
    'Heritage',
    'Human rights',
    'Identity',
    'Inclusion',
    'LGBTQIA+',
    'Mental health',
    'Migration',
    'Mobility',
    'New technologies',
    'Other',
    'Refugees',
    'Rural context',
    'Social justice',
    'Status of the Artist',
    'Sustainability',
    'Urbanism',
    'Working conditions',
    'Youth'
);
    echo '<h4 style="padding-bottom: 25px; font-size: 20px; font-weight: 600;">Topics which are a priority in my activity</h4>';	
    foreach ($all_terms as $term) {
        $checked = in_array($term, (array)$topics_covered) ? 'checked' : '';
        echo '<label class="checkbox-cust"><input type="checkbox" name="topics_covered[]" value="' . sanitize_text_field($term) . '" ' . $checked . '> ' . $term . '</label>';
    }
    ?>
</div>
</div>

<div class="checkbox-container cont-pb">
	    <div class="checkbox-group">
        <?php if (!empty($offer_work_choices)): ?>
            <label for="i_offer_work">I offer:</label>
            <?php foreach ($offer_work_choices as $value => $label): ?>
                <label class="checkbox-cust">
						<input type="checkbox" name="i_offer_work[]" value="<?php echo $value; ?>" <?php echo in_array($value, (array) $i_offer_work) ? 'checked' : ''; ?>> <?php echo $label; ?><br>
					</label>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="checkbox-group w-100">
        <label for="all_work" class="input-cust-cond">My performing arts work(s):</label>
        <textarea name="all_work" id="all_work" class="input-cust input-cust-1 area-wd input-cust-cond area-cust" rows="6"><?php echo esc_textarea(htmlspecialchars_decode($all_work)); ?></textarea>
		<div id="char-count-work" class="char-count input-cust-cond"></div>
	</div>
</div>
<div class="checkbox-container cont-pb">
  <div class="checkbox-group">
    <?php if (!empty($offer_tour_choices)): ?>
      <?php foreach ($offer_tour_choices as $value => $label): ?>
        <label class="checkbox-cust">
          <input type="checkbox" name="i_offer_tour[]" value="<?php echo $value; ?>" <?php echo in_array($value, (array) $i_offer_tour) ? 'checked' : ''; ?>> <?php echo $label; ?><br>
        </label>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <div class="checkbox-group w-100">
    <label for="all_tour" class="input-cust-cond">My touring opportunity(ies):</label>
    <textarea name="all_tour" id="all_tour" class="input-cust input-cust-1 area-wd input-cust-cond area-cust" rows="6"><?php echo esc_textarea(htmlspecialchars_decode($all_tour)); ?></textarea>
	  <div id="char-count-tour" class="char-count input-cust-cond"></div>
  </div>
</div>
        <input type="hidden" name="update_profile" value="1" />
        <input type="submit" class="update-btn" value="Update Profile" />
    </form>
    <?php
} else {
    // If the user is not logged in, display a message or redirect to login
    echo '<p>Please log in to view your profile.</p>';
}
		?>
    </div>
</section>
<?php
get_footer();
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setupCharacterCount280('your_needs', 'char-count-your-needs');
        setupCharacterCount280('your_offer', 'char-count-your-offer');
    });

    function setupCharacterCount280(textAreaId, charCountId) {
        var maxChars = 280;
        var textArea = document.getElementById(textAreaId);
        var charCount = document.getElementById(charCountId);
        // Initial character count
        updateCharacterCount();
        // Update character count on input
        textArea.addEventListener('input', function() {
            updateCharacterCount();
        });
        textArea.addEventListener('keypress', function(event) {
            var remainingChars = maxChars - textArea.value.length;
            
            if (remainingChars <= 0) {
                event.preventDefault();
            }
        });
        function updateCharacterCount() {
            var remainingChars = maxChars - textArea.value.length;
            var currentChars = maxChars - remainingChars;

            charCount.textContent = currentChars + ' of ' + maxChars + ' max characters';
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var accountTypeRadios = document.querySelectorAll('[name="account_type"]');
        var organisationLabel = document.querySelector('.input-cust-cond');
        var organisationTextarea = document.querySelector('[name="name_of_organisation"]');
        
        accountTypeRadios.forEach(function (radio) {
            radio.addEventListener('change', function () {
                var isOrganisationSelected = Array.from(accountTypeRadios).some(function (r) {
                    return r.value === 'Organisation' && r.checked;
                });

                organisationLabel.style.display = isOrganisationSelected ? 'block' : 'none';
                organisationTextarea.style.display = isOrganisationSelected ? 'block' : 'none';
            });
        });

        // Trigger the change event on page load to set initial visibility
        accountTypeRadios.forEach(function (radio) {
            radio.dispatchEvent(new Event('change'));
        });
    });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Get the checkbox and textarea elements
    var offeredWorkCheckbox = document.querySelector('[name="i_offer_work[]"]');
    var allWorkLabel = document.querySelector('[for="all_work"]');
    var allWorkTextarea = document.querySelector('[name="all_work"]');
    var charCountWork = document.getElementById('char-count-work');

    // Add event listener to the checkbox
    offeredWorkCheckbox.addEventListener('change', function () {
      // Toggle the visibility of the label and textarea based on checkbox state
      allWorkLabel.style.display = offeredWorkCheckbox.checked ? 'block' : 'none';
      allWorkTextarea.style.display = offeredWorkCheckbox.checked ? 'block' : 'none';
	  charCountWork.style.display = offeredWorkCheckbox.checked ? 'block' : 'none';
    });

    // Trigger the change event on page load to set initial visibility
    offeredWorkCheckbox.dispatchEvent(new Event('change'));
  });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    setupCharacterCount('all_tour', 'char-count-tour');
    handleTourCheckboxChange();

    var tourCheckbox = document.querySelector('input[name="i_offer_tour[]"][value="Touring opportunity(ies)"]');
    tourCheckbox.addEventListener('change', handleTourCheckboxChange);
});

function handleTourCheckboxChange() {
    var tourCheckbox = document.querySelector('input[name="i_offer_tour[]"][value="Touring opportunity(ies)"]');
    var tourTextarea = document.getElementById('all_tour');
    var charCountTour = document.getElementById('char-count-tour');

    if (tourCheckbox && tourTextarea && charCountTour) {
        if (!tourCheckbox.checked) {
            // If checkbox is unchecked, clear the textarea content
            tourTextarea.value = '';
            charCountTour.textContent = '0 of 1000 max characters'; // Update the character count
        } else {
            // If checkbox is checked, trigger the input event to update the character count
            tourTextarea.dispatchEvent(new Event('input'));
        }
    }
}

</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setupCharacterCount('all_work', 'char-count-work');
        setupCharacterCount('all_tour', 'char-count-tour');
        handleCheckboxChange();
        var checkbox = document.querySelector('input[name="i_offer_work[]"][value="Performing arts work(s)"]');
        checkbox.addEventListener('change', handleCheckboxChange);
    });
    function setupCharacterCount(textAreaId, charCountId) {
        var maxChars = 1000;
        var textArea = document.getElementById(textAreaId);
        var charCount = document.getElementById(charCountId);
        updateCharacterCount();
        textArea.addEventListener('input', function() {
            updateCharacterCount();
        });
        textArea.addEventListener('keypress', function(event) {
            var remainingChars = maxChars - textArea.value.length;

            if (remainingChars <= 0) {
                event.preventDefault();
            }
        });

        function updateCharacterCount() {
            var remainingChars = maxChars - textArea.value.length;
            var currentChars = maxChars - remainingChars;
            charCount.textContent = currentChars + ' of ' + maxChars + ' max characters';
        }
    }
    function handleCheckboxChange() {
    var checkbox = document.querySelector('input[name="i_offer_work[]"][value="Performing arts work(s)"]');
    var textarea = document.getElementById('all_work');
    var charCount = document.getElementById('char-count-work');

    if (checkbox && textarea && charCount) {
        if (!checkbox.checked) {
            // If checkbox is unchecked, clear the textarea content
            textarea.value = '';
            charCount.textContent = '0 of 1000 max characters'; // Update the character count
        } else {
            // If checkbox is checked, trigger the input event to update the character count
            textarea.dispatchEvent(new Event('input'));
        }
    }
}
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Get the checkbox and textarea elements
    var offeredTourCheckbox = document.querySelector('[name="i_offer_tour[]"]');
    var allTourLabel = document.querySelector('[for="all_tour"]');
    var allTourTextarea = document.querySelector('[name="all_tour"]');
    var charCountTour = document.getElementById('char-count-tour');

    // Add event listener to the checkbox
    offeredTourCheckbox.addEventListener('change', function () {
      // Toggle the visibility of the label and textarea based on checkbox state
      allTourLabel.style.display = offeredTourCheckbox.checked ? 'block' : 'none';
      allTourTextarea.style.display = offeredTourCheckbox.checked ? 'block' : 'none';
      charCountTour.style.display = offeredTourCheckbox.checked ? 'block' : 'none';
    });

    // Trigger the change event on page load to set initial visibility
    offeredTourCheckbox.dispatchEvent(new Event('change'));
  });
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("body").addClass('pe-body--mint');
        jQuery(".footer").addClass('footer--dark');
    });
	
// Added by Uyen
    document.addEventListener('DOMContentLoaded', function() {
        setupCharacterCount('description', 'char-count-your-description');
    });

    function setupCharacterCount(textAreaId, charCountId) {
        var maxChars = 500; // Change this value to the desired maximum character count
        var textArea = document.getElementById(textAreaId);
        var charCount = document.getElementById(charCountId);

        // Initial character count
        updateCharacterCount();

        // Update character count on input
        textArea.addEventListener('input', function() {
            updateCharacterCount();
        });

        // Prevent typing when the maximum character limit is reached
        textArea.addEventListener('keypress', function(event) {
            var remainingChars = maxChars - textArea.value.length;

            if (remainingChars <= 0) {
                event.preventDefault();
            }
        });

        function updateCharacterCount() {
            var remainingChars = maxChars - textArea.value.length;
            var currentChars = maxChars - remainingChars;

            charCount.textContent = currentChars + ' of ' + maxChars + ' max characters';
        }
    }

</script>