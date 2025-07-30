<section class="concept-launch-section"<?php if ($concept_image): ?> style="background-image: url('<?php echo esc_url($concept_image['url']); ?>');"<?php endif; ?>>
    <div class="container">
        <div class="concept-layout">
            <div class="concept-left">
                <?php if ($concept_title): ?>
                    <h2 class="concept-title"><?php echo esc_html($concept_title); ?></h2>
                <?php endif; ?>
                <?php if ($concept_subtitle): ?>
                    <h4 class="concept-subtitle"><?php echo esc_html($concept_subtitle); ?></h4>
                <?php endif; ?>
            </div>
            <div class="concept-right">
                <?php if ($concept_list): ?>
                    <div class="concept-list">
                        <?php foreach ($concept_list as $index => $row): ?>
                            <div class="concept-step <?php echo $index === 2 ? 'highlight-step' : ''; ?>">
                                <p><?php echo esc_html($row['concept_text']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
