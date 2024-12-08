<div class="row">
    <div class="col-lg-9 col-md-8">
        <div class="cart-table">
            <div class="cart-heading-text">
                <h3><?php echo get_phrase('Your Cart Items') ?></h3>
            </div>
            <div class="cart-scroll-bar">
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col">
                                <p><?php echo get_phrase('Items') ?></p>
                            </th>
                            <th scope="col">
                                <p class="text-start"><?php echo get_phrase('Price') ?></p>
                            </th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($this->session->userdata('cart_items') as $item): ?>
                            <?php $course_details = $this->crud_model->get_course_by_id($item)->row_array(); ?>
                            <tr>
                                <td>
                                    <div class="cart-table-image">
                                        <img loading="lazy" src="<?php echo $this->crud_model->get_course_thumbnail_url($course_details['id']); ?>">
                                        <a href="<?php echo site_url('home/course/' . slugify($course_details['title']) . '/' . $course_details['id']) ?>">
                                            <h5 class="my-1"><?php echo $course_details['title']; ?></h5>
                                            <p class="ellipsis-line-2"><?php echo $course_details['short_description']; ?></p>
                                        </a>
                                    </div>
                                </td>
                                <td class="d-flex">
                                    <?php if ($course_details['is_free_course']): ?>
                                        <h4><?php echo get_phrase('Free'); ?></h4>
                                    <?php elseif ($course_details['discount_flag']): ?>
                                        <?php $total += $course_details['discounted_price']; ?>
                                        <h4><?php echo currency($course_details['discounted_price']); ?></h4>
                                        <h6 class="mt-2 ms-2"><del><?php echo currency($course_details['price']); ?></del></h6>
                                    <?php else: ?>
                                        <?php $total += $course_details['price']; ?>
                                        <h4><?php echo currency($course_details['price']); ?></h4>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a class="ms-auto" href="#" onclick="actionTo('<?php echo site_url('home/handle_cart_items/' . $course_details['id']); ?>');"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-4">
        <div class="cart-total">
            <h4><?php echo get_phrase('Total'); ?></h4>

            <!-- Coupon Code Handling -->
            <?php if (isset($coupon_code) && !empty($coupon_code)) : ?>
                <?php if ($this->crud_model->check_coupon_validity($coupon_code)): ?>
                    <?php $coupon_details = $this->crud_model->get_coupon_details_by_code($coupon_code)->row_array(); ?>
                    <?php $coupon_discounted_price = ($total * $coupon_details['discount_percentage']) / 100; ?>

                    <div class="alert alert-success text-13px text-center py-2" role="alert">
                        <?php echo get_phrase('You received') . ' ' . currency($coupon_discounted_price) . ' (' . $coupon_details['discount_percentage'] . '%) ' . site_phrase('coupon discount'); ?>
                    </div>
                    <?php
                    $total = $total - $coupon_discounted_price;
                    $total = ($total > 0) ? $total : 0;
                    $this->session->set_userdata('applied_coupon', $coupon_code);
                    ?>
                <?php else: ?>
                    <div class="alert alert-danger text-13px text-center py-2" role="alert">
                        <?php echo get_phrase('Your coupon code has expired'); ?>
                        <?php $this->session->set_userdata('applied_coupon', null); ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <?php $this->session->set_userdata('applied_coupon', null); ?>
            <?php endif; ?>

            <div class="tax">
                <h6><?php echo get_phrase('Subtotal') ?></h6>
                <h6><?php echo currency($total); ?></h6>
            </div>

            <!-- Tax Handling -->
            <?php if (get_settings('course_selling_tax') > 0): ?>
                <div class="sub-total">
                    <?php
                    $tax = round(($total / 100) * get_settings('course_selling_tax'), 2);
                    $total = round($total + ($total / 100) * get_settings('course_selling_tax'), 2);
                    ?>
                    <h6><?php echo get_phrase('Tax') ?></h6>
                    <h6><?php echo currency($tax) . ' <small class="fw-400">(' . get_settings('course_selling_tax') . '%)</small>'; ?></h6>
                </div>
            <?php endif; ?>

            <div class="tax">
                <?php $this->session->set_userdata('total_price_of_checking_out', $total); ?>
                <h6><?php echo get_phrase('Total') ?></h6>
                <h6><?php echo currency($total); ?></h6>
            </div>

            <form class="ajaxForm" action="<?php echo site_url('home/apply_coupon') ?>" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="coupon_code" class="form-control text-14px" placeholder="<?php echo site_phrase('Apply coupon'); ?>" aria-label="<?php echo site_phrase('Apply coupon'); ?>">
                    <button class="btn-primary btn-primary text-white px-2 py-2 radius-end-8 text-14px" type="submit"><?php echo get_phrase('Apply') ?></button>
                </div>
            </form>

            <!-- Payment Handling -->
            <form id="payment-form" action="https://ifmap.ci/payment/index.php" method="POST">
                <div class="input-group mb-1">
                    <input type="checkbox" id="is_gift" name="is_gift" onchange="
                        if ($(this).prop('checked')==true){ 
                            $('#gift_email_section').removeClass('d-hidden');
                        } else {
                            $('#gift_email_section').addClass('d-hidden');
                        }
                        if ($('#gift_email').prop('required')) {
                            $('#gift_email').prop('required', false);
                        } else {
                            $('#gift_email').prop('required', true);
                        }
                    " value="1" <?php if (isset($_GET['gift'])) echo 'checked'; ?>>
                    <label for="is_gift" class="ms-2 text-14px"><?php echo get_phrase('Send as a gift') ?></label>
                </div>
                <div id="gift_email_section" class="<?php if (isset($_GET['gift'])): else: echo 'd-hidden';
                                                    endif; ?>">
                    <div class="input-group mb-0">
                        <input type="email" name="gift_email" id="gift_email" class="form-control text-14px py-2 w-100" placeholder="<?php echo site_phrase('Email address'); ?>" <?php if (isset($_GET['gift'])) echo 'required'; ?>>
                    </div>
                    <span id="check_gift_user_message" class="text-12px"></span>
                </div>

                <!-- Submit Payment -->
                <button id="payment-button" type="submit" class="btn btn-primary px-2 w-100">
                    <?php echo get_phrase('Continue to Payment') ?>
                </button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById('payment-button').addEventListener('click', function(e) {
        e.preventDefault(); // Empêcher l'envoi du formulaire par défaut

        var form = document.getElementById('payment-form'); // Récupérer le formulaire

        // Créer un objet FormData avec les données du formulaire
        var formData = new FormData(form);

        // Ajouter les éléments du panier au formData
        <?php
        // Ajouter les éléments du panier dans un tableau JavaScript
        $cart_items = $this->session->userdata('cart_items');
        foreach ($cart_items as $item) {
            $course_details = $this->crud_model->get_course_by_id($item)->row_array();
        ?>
            // Ajouter les détails de chaque cours
            formData.append("cart_items[]", "<?php echo $course_details['id']; ?>");
            formData.append("cart_items_price[]", "<?php echo ($course_details['discount_flag'] ? $course_details['discounted_price'] : $course_details['price']); ?>");
            formData.append("cart_items_names[]", "<?php echo addslashes($course_details['title']); ?>");
            formData.append("cart_items_descriptions[]", "<?php echo addslashes($course_details['short_description']); ?>");
            formData.append("cart_items_images[]", "<?php echo $this->crud_model->get_course_thumbnail_url($course_details['id']); ?>");
            formData.append("cart_items_original_price[]", "<?php echo $course_details['price']; ?>");
            formData.append("cart_items_discounted_price[]", "<?php echo $course_details['discounted_price']; ?>");
        <?php } ?>

        // Ajouter le total de la commande
        formData.append("total_price", "<?php echo $total; ?>");

        // Ajouter le code du coupon si appliqué
        <?php if (isset($coupon_code) && !empty($coupon_code)) : ?>
            formData.append("coupon_code", "<?php echo $coupon_code; ?>");
        <?php endif; ?>

        // Créer un formulaire dynamique
        var dynamicForm = document.createElement('form');
        dynamicForm.action = 'https://ifmap.ci/payment/index.php'; // URL de redirection
        dynamicForm.method = 'POST'; // Méthode POST

        // Ajouter les champs au formulaire dynamique
        for (var [key, value] of formData.entries()) {
            var input = document.createElement('input');
            input.type = 'hidden'; // Champ caché
            input.name = key;
            input.value = value;
            dynamicForm.appendChild(input);
        }

        // Ajouter le formulaire à la page
        document.body.appendChild(dynamicForm);

        // Soumettre le formulaire
        dynamicForm.submit();
    });
</script>

</script>