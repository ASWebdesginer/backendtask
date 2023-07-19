<?php
// Add Meta Fields for FAQs
function faq_generator_add_meta_fields()
{
    add_meta_box(
        'faq_questions_answers',
        'Questions and Answers',
        'faq_generator_render_questions_answers_field',
        'faq',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'faq_generator_add_meta_fields');

// Render Questions and Answers Field
function faq_generator_render_questions_answers_field($post)
{
    $faqs = get_post_meta($post->ID, 'faq_questions_answers', true);
    $faqs = !empty($faqs) ? $faqs : array();

    wp_nonce_field('faq_generator_save_questions_answers', 'faq_generator_questions_answers_nonce');
?>
    <div id="faq-questions-answers-wrapper">
        <?php if (!empty($faqs)) : ?>
            <?php foreach ($faqs as $index => $faq) : ?>
                <div class="faq-question-answer">
                    <input type="text" name="faq_questions[]" placeholder="Question" value="<?php echo esc_attr($faq['question']); ?>" />
                    <textarea name="faq_answers[]" placeholder="Answer"><?php echo esc_textarea($faq['answer']); ?></textarea>
                    <span class="remove-faq"><button type="button" class="button">Remove</button></span>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="faq-question-answer">
                <input type="text" name="faq_questions[]" placeholder="Question" />
                <textarea name="faq_answers[]" placeholder="Answer"></textarea>
                <span class="remove-faq"><button type="button" class="button">Remove</button></span>
            </div>
        <?php endif; ?>
        <div class="faq-question-answer" style="display:none;">
            <input type="text" name="faq_questions[]" placeholder="Question" />
            <textarea name="faq_answers[]" placeholder="Answer"></textarea>
            <span class="remove-faq"><button type="button" class="button">Remove</button></span>
        </div>
        <button type="button" class="button add-faq">Add FAQ</button>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('.add-faq').click(function() {
                $('#faq-questions-answers-wrapper .faq-question-answer:hidden:first').show();
            });

            $('#faq-questions-answers-wrapper').on('click', '.remove-faq', function() {
                $(this).closest('.faq-question-answer').remove();
            });
        });
    </script>
<?php
}
// Save Meta Fields for FAQs
function faq_generator_save_meta_fields($post_id)
{
    if (!isset($_POST['faq_generator_questions_answers_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['faq_generator_questions_answers_nonce'], 'faq_generator_save_questions_answers')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $questions = !empty($_POST['faq_questions']) ? $_POST['faq_questions'] : array();
    $answers = !empty($_POST['faq_answers']) ? $_POST['faq_answers'] : array();
    $faqs = array();

    foreach ($questions as $index => $question) {
        if (!empty($question) && isset($answers[$index])) {
            $faq = array(
                'question' => sanitize_text_field($question),
                'answer' => wp_kses_post($answers[$index]),
            );

            $faqs[] = $faq;
        }
    }

    // Get the existing FAQs
    $existing_faqs = get_post_meta($post_id, 'faq_questions_answers', true);

    // Merge existing FAQs with the new FAQs
    $merged_faqs = array_merge($existing_faqs, $faqs);

    // Update the FAQs meta field
    update_post_meta($post_id, 'faq_questions_answers', $merged_faqs);
}
add_action('save_post', 'faq_generator_save_meta_fields');
