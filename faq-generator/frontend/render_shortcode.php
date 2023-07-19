<?php
// Render FAQs using Shortcode
// Render FAQs using Shortcode
function faq_generator_render_faqs($atts)
{
    global $post;

    $faqs = get_post_meta($post->ID, 'faq_questions_answers', true);

    if (empty($faqs)) {
        return 'No FAQs found for the current post.';
    }

    $output = '<div class="faq-list">';

    foreach ($faqs as $faq) {
        $question = isset($faq['question']) ? $faq['question'] : '';
        $answer = isset($faq['answer']) ? $faq['answer'] : '';

        $output .= '<details class="faq">';
        $output .= '<summary class="faq-question">' . esc_html($question) . '</summary>';
        $output .= '<p class="faq-answer">' . wpautop(esc_html($answer)) . '</p>';
        $output .= '</details>';
    }

    $output .= '</div>';

    return $output;
}
add_shortcode('faq', 'faq_generator_render_faqs');
