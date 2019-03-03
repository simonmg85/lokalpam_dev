jQuery(function($) {
    if (jQuery("tr").is('#field_faqs')) {
        var tabs = jQuery("#field_faqs").find("#tabs").tabs()
    }
    jQuery('#tabsbtn').click(function() {
        var qstring = jQuery('div#tabs').data('qstring');
        var ansstring = jQuery('div#tabs').data('ansstring');
        var faqtitle = jQuery('div#tabs').data('faqtitle');
        var ul = tabs.find("ul");
        var list = Number(ul.find("li").length) + 1;
        jQuery("<li><a href='#tab" + list + "'>" + qstring + " " + list + "</a></li>").appendTo(ul);
        var content = "<div class='form-group'><label for='faq-" + list + "'>" + faqtitle + " " + list + "</label><input type='text' class='form-control' name='faqs[faq][" + list + "]' id='faq-" + list + "' placeholder='" + qstring + " " + list + "'></div><div class='form-group'><label for='faq-ans-" + list + "'>Answer " + list + "</label><textarea class='form-control' name='faqs[faqans][" + list + "]' rows='8' id='faq-ans-" + list + "'></textarea></div>";
        jQuery("<div id='tab" + list + "'><p>" + content + "</p></div>").appendTo(tabs);
        tabs.tabs("refresh")
    });
    jQuery('button.add-hours').on('click', function(event) {
        event.preventDefault();
 
        var $this = jQuery(this);
        var lp2times = $this.closest('#day-hours-BusinessHours').data('lpenabletwotimes');
        var error = !1;
        var fullday = '';
        var fullhoursclass = '';
        var lpdash = "-";
        if (lp2times == "disable") {
            var weekday = jQuery('select.weekday').val();
            if (jQuery(".fulldayopen").is(":checked")) {
                jQuery('.fulldayopen').attr('checked', !1);
                jQuery('select.hours-start').prop("disabled", !1);
                jQuery('select.hours-end').prop("disabled", !1);
                var startVal = '';
                var endVal = '';
                var hrstart = '';
                var hrend = '';
                fullday = $this.data('fullday');
                fullhoursclass = 'fullhours';
                lpdash = ""
            } else {
                var startVal = jQuery('select.hours-start').val();
                var endVal = jQuery('select.hours-end').val();
                var hrstart = jQuery('select.hours-start').find('option:selected').text();
                var hrend = jQuery('select.hours-end').find('option:selected').text();
                var startVal_digit = hrstart.replace(':', '');
                var endVal_digit = hrend.replace(':', '');
                if (startVal_digit > endVal_digit) {
                    nextWeekday = jQuery("select.weekday option:selected+option").val();
                    if (typeof nextWeekday === "undefined") {
                        nextWeekday = jQuery("select.weekday").find("option:first-child").val()
                    }
                    weekday = weekday + "-" + nextWeekday
                }
            }
            var sorryMsg = jQuery(this).data('sorrymsg');
            var alreadyadded = jQuery(this).data('alreadyadded');
            if( $this.hasClass('lp-add-hours-st') )
            {
                var remove = '<i class="fa fa-times"></i>';
            }
            else
            {
                var remove  =   jQuery(this).data('remove');
            }

            jQuery('.hours-display .hours').each(function(index, element) {
                var weekdayTExt = jQuery(element).children('.weekday').text();
                if (weekdayTExt == weekday) {
                    alert(sorryMsg + '! ' + weekday + ' ' + alreadyadded);
                    error = !0
                }
            });
            if (error != !0) {
                jQuery('.hours-display').append("<div class='hours " + fullhoursclass + "'><span class='weekday'>" + weekday + "</span><span class='start-end fullday'>" + fullday + "</span><span class='start'>" + hrstart + "</span><span>" + lpdash + "</span><span class='end'>" + hrend + "</span><a class='remove-hours' href='#'>" + remove + "</a><input name='business_hours[" + weekday + "][open]' value='" + startVal + "' type='hidden'><input name='business_hours[" + weekday + "][close]' value='" + endVal + "' type='hidden'></div>");
                var current = jQuery('select.weekday').find('option:selected');
                var nextval = current.next();
                current.removeAttr('selected');
                nextval.attr('selected', 'selected');
                jQuery('select.weekday').trigger('change.select2')
            }
        } else {
            var lptwentlyfourisopen = '';
            var weekday = jQuery('select.weekday').val();
            var weekday1 = weekday;
            var weekday2 = weekday;
            if (jQuery(".fulldayopen").is(":checked")) {
                lptwentlyfourisopen = 'yes';
                jQuery('.fulldayopen').attr('checked', !1);
                jQuery('select.hours-start').prop("disabled", !1);
                jQuery('select.hours-end').prop("disabled", !1);
                jQuery('select.hours-start2').prop("disabled", !1);
                jQuery('select.hours-end2').prop("disabled", !1);
                var startVal1 = '';
                var endVal1 = '';
                var hrstart1 = '';
                var hrend1 = '';
                var startVal2 = '';
                var endVal2 = '';
                var hrstart2 = '';
                var hrend2 = '';
                fullday = $this.data('fullday');
                fullhoursclass = 'fullhours';
                lpdash = ""
            } else {
                var startVal1 = jQuery('select.hours-start').val();
                var endVal1 = jQuery('select.hours-end').val();
                var hrstart1 = jQuery('select.hours-start').find('option:selected').text();
                var hrend1 = jQuery('select.hours-end').find('option:selected').text();
                var startVal1_digit = hrstart1.replace(':', '');
                var endVal1_digit = hrend1.replace(':', '');
                if (startVal1_digit > endVal1_digit) {
                    nextWeekday = jQuery("select.weekday option:selected+option").val();
                    if (typeof nextWeekday === "undefined") {
                        nextWeekday = jQuery("select.weekday").find("option:first-child").val()
                    }
                    weekday1 = weekday + "-" + nextWeekday
                }
                var startVal2 = jQuery('select.hours-start2').val();
                var endVal2 = jQuery('select.hours-end2').val();
                var hrstart2 = jQuery('select.hours-start2').find('option:selected').text();
                var hrend2 = jQuery('select.hours-end2').find('option:selected').text();
                var startVal2_digit = hrstart2.replace(':', '');
                var endVal2_digit = hrend2.replace(':', '');
                if (startVal2_digit > endVal2_digit) {
                    nextWeekday = jQuery("select.weekday option:selected+option").val();
                    if (typeof nextWeekday === "undefined") {
                        nextWeekday = jQuery("select.weekday").find("option:first-child").val()
                    }
                    weekday2 = weekday + "-" + nextWeekday
                }
            }
            var sorryMsg = jQuery(this).data('sorrymsg');
            var alreadyadded = jQuery(this).data('alreadyadded');
            if( jQuery(this).hasClass('lp-add-hours-st') )
            {

                var remove = '<i class="fa fa-times"></i>';
            }
            else
            {
                var remove  =   jQuery(this).data('remove');
            }
            jQuery('.hours-display .hours').each(function(index, element) {
                var weekdayTExt = jQuery(element).children('.weekday').text();
                if (weekdayTExt == weekday) {
                    alert(sorryMsg + '! ' + weekday + ' ' + alreadyadded);
                    error = !0
                }
            });
            if (error != !0) {
                if ((jQuery(".lp-check-doubletime .enable2ndday").is(":checked")) && (lptwentlyfourisopen === "")) {
                    jQuery('.hours-display').append("<div class='hours " + fullhoursclass + "'><span class='weekday'>" + weekday + "</span><span class='start-end fullday'>" + fullday + "</span><span class='start'>" + hrstart1 + "</span><span>" + lpdash + "</span><span class='end'>" + hrend1 + "</span><a class='remove-hours' href='#'>" + remove + "</a><br><span class='weekday'>&nbsp;</span><span class='start'>" + hrstart2 + "</span><span>" + lpdash + "</span><span class='end'>" + hrend2 + "</span><input name='business_hours[" + weekday1 + "][open][0]' value='" + startVal1 + "' type='hidden'><input name='business_hours[" + weekday1 + "][close][0]' value='" + endVal1 + "' type='hidden'><input name='business_hours[" + weekday2 + "][open][1]' value='" + startVal2 + "' type='hidden'><input name='business_hours[" + weekday2 + "][close][1]' value='" + endVal2 + "' type='hidden'></div>")
                } else {
                    jQuery('.hours-display').append("<div class='hours " + fullhoursclass + "'><span class='weekday'>" + weekday1 + "</span><span class='start-end fullday'>" + fullday + "</span><span class='start'>" + hrstart1 + "</span><span>" + lpdash + "</span><span class='end'>" + hrend1 + "</span><a class='remove-hours' href='#'>" + remove + "</a><input name='business_hours[" + weekday1 + "][open]' value='" + startVal1 + "' type='hidden'><input name='business_hours[" + weekday1 + "][close]' value='" + endVal1 + "' type='hidden'></div>")
                }
                var current = jQuery('select.weekday').find('option:selected');
                var nextval = current.next();
                current.removeAttr('selected');
                nextval.attr('selected', 'selected');
                jQuery('select.weekday').trigger('change.select2')
            }
        }
    });
    jQuery(document).ready(function() {
        jQuery('select.hours-start2').prop("disabled", !0);
        jQuery('select.hours-end2').prop("disabled", !0);
        jQuery(".lp-check-doubletime .enable2ndday").change(function() {
            if (this.checked) {
                jQuery('select.hours-start2').prop("disabled", !1);
                jQuery('select.hours-end2').prop("disabled", !1);
                jQuery('.hours-select.lp-slot2-time').slideToggle(300)
            } else {
                jQuery('select.hours-start2').prop("disabled", !0);
                jQuery('select.hours-end2').prop("disabled", !0);
                jQuery('.hours-select.lp-slot2-time').slideToggle(300)
            }
        })
    });
    jQuery(document).on('click', 'a.remove-hours', function(event) {
        event.preventDefault();
        jQuery(this).parent('.hours').remove()
    });
    jQuery('.metaincbtn').click(function() {
        var remText = jQuery(this).data('remove');
        var div = jQuery(this).closest('.type_inrement');
        var dataID = div.data("id");
        var list = Number(jQuery('.' + dataID).find("input").length) + 1;
        var tdContent = '<div class="lp-addmore-wrap">';
        tdContent += "<input type='text' name='" + dataID + "[" + list + "]' id='" + dataID + "' value='' />";
        tdContent += '<a href="" class="lp-remove-more">' + remText + '</a>';
        tdContent += '</div>';
        jQuery(tdContent).appendTo('.' + dataID)
    });
    jQuery(document).on('click', '.lp_price_plan_addmore a.lp-remove-more', function(e) {
        e.preventDefault();
        var $target = jQuery(this).closest('.lp-addmore-wrap');
        $target.slideToggle('slow', function() {
            $target.remove()
        })
    })
});
jQuery(function() {
    var div = jQuery('.type_inrement');
    var th = div.find("th");
    var td = div.find("td");
    var dataID = div.data("id");
    var dataVALUE = div.data("value");
    var dataNAME = div.data("name");
    var listfirst = Number(td.find("input").length);
    div.find("th").find('strong').text(dataNAME + " " + listfirst);
    jQuery('#metaincbtn').click(function() {
        var list = Number(td.find("input").length) + 1;
        var thContent = "<label for='" + dataID + "[" + list + "]'><strong>" + dataNAME + " " + list + "</strong><span></span></label>";
        var tdContent = "<input type='text' name='" + dataID + "[" + list + "]' id='" + dataID + "' value='" + dataVALUE + "' />";
        jQuery(thContent).appendTo(th);
        jQuery(tdContent).appendTo(td)
    });
    jQuery(window).load(function($) {
        var listID = jQuery('#post_ID').val();
        var termID = jQuery('#listing-categorychecklist input:checked').map(function() {
            return this.value
        }).get();
        if (termID != undefined && termID != '') {
            jQuery('.extrafieldsdiv').remove();
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: {
                    'action': 'lp_get_fields',
                    'term_id': termID,
                    'list_id': listID,
                },
                success: function(data) {
                    if (data) {
                        $output1 = "<div id='commentstatusdiv12' class='lp-metaboxes postbox extrafieldsdiv'><h2 class='hndle ui-sortable-handle'><span>Extra Fields</span></h2><div class='inside'><table class='form-table lp-metaboxes'><tbody>";
                        $outputf = "<div id='commentstatusdiv' class='lp-metaboxes postbox extrafieldsdiv'><h2 class='hndle ui-sortable-handle'><span>Please select Features</span></h2><div class='inside'><table class='form-table lp-metaboxes'><tbody>";
                        $output2 = "</tbody></table></div></div>";
                        if (data.features != null) {
                            jQuery('#postbox-container-2').append($outputf + data.features + $output2)
                        } else {
                            jQuery('#postbox-container-2').append($output1 + '<p>No Fields Associated</p>' + $output2)
                        }
                        if (data.fields != null) {
                            jQuery('#postbox-container-2').append($output1 + data.fields + $output2)
                        } else {
                            jQuery('#postbox-container-2').append($output1 + '<p>No Fields Associated</p>' + $output2)
                        }
                    }
                }
            })
        } else {
            jQuery('.extrafieldsdiv').remove()
        }
    });
    jQuery(document).on('change', '#listing-categorychecklist input', function() {
        var listID = jQuery('#post_ID').val();
        var termID = jQuery('#listing-categorychecklist input:checked').map(function() {
            return this.value
        }).get();
        if (termID != undefined && termID != '') {
            jQuery('.extrafieldsdiv').remove();
            jQuery("#listing-categorychecklist input").attr("disabled", !0);
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: {
                    'action': 'lp_get_fields',
                    'term_id': termID,
                    'list_id': listID,
                },
                success: function(data) {
                    jQuery("#listing-categorychecklist input").removeAttr("disabled");
                    if (data) {
                        $output1 = "<div id='commentstatusdiv12' class='lp-metaboxes postbox extrafieldsdiv'><h2 class='hndle ui-sortable-handle'><span>Extra Fields</span></h2><div class='inside'><table class='form-table lp-metaboxes'><tbody>";
                        $outputf = "<div id='commentstatusdiv' class='lp-metaboxes postbox extrafieldsdiv'><h2 class='hndle ui-sortable-handle'><span>Please select Features</span></h2><div class='inside'><table class='form-table lp-metaboxes'><tbody>";
                        $output2 = "</tbody></table></div></div>";
                        if (data.features != null) {
                            jQuery('#postbox-container-2').append($outputf + data.features + $output2)
                        } else {
                            jQuery('#postbox-container-2').append($output1 + '<p>No Fields Associated</p>' + $output2)
                        }
                        if (data.fields != null) {
                            jQuery('#postbox-container-2').append($output1 + data.fields + $output2)
                        } else {
                            jQuery('#postbox-container-2').append($output1 + '<p>No Fields Associated</p>' + $output2)
                        }
                    }
                }
            })
        } else {
            jQuery('.extrafieldsdiv').remove()
        }
    });
    jQuery(window).load(function($) {
        var checkposttype = jQuery('input#post_type').val();
        lplistingid = jQuery('input#post_ID').val();
        if (checkposttype === "listing") {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: {
                    'action': 'lp_get_excluded_fields',
                    'lplistingid': lplistingid,
                },
                success: function(data) {
                    if (data) {
                        $output1 = "<div id='lpcommentstatusdiv' class='lp-metaboxes postbox extrafieldsdivva'><h2 class='hndle ui-sortable-handle'><span>Extra Fields</span></h2><div class='inside'><table class='form-table lp-metaboxes'><tbody>";
                        $output2 = "</tbody></table></div></div>";
                        if (data.fields != null) {
                            jQuery('#postbox-container-2').append($output1 + data.fields + $output2)
                        }
                    }
                }
            })
        }
    });
    jQuery(document).ready(function() {
        jQuery(".fulldayopen").change(function() {
            if (this.checked) {
                jQuery('select.hours-start').prop("disabled", !0);
                jQuery('select.hours-end').prop("disabled", !0);
                jQuery('select.hours-start2').prop("disabled", !0);
                jQuery('select.hours-end2').prop("disabled", !0)
            } else {
                jQuery('select.hours-start').prop("disabled", !1);
                jQuery('select.hours-end').prop("disabled", !1);
                jQuery('select.hours-start2').prop("disabled", !1);
                jQuery('select.hours-end2').prop("disabled", !1)
            }
        });
        jQuery('.type_listing select').on('click', function() {
            var $this = jQuery(this);
            if (jQuery(this).find('option').length <= 1) {
                jQuery('.lp-listing-sping').show();
                jQuery.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: {
                        'action': 'lp_get_all_p_listings',
                    },
                    dataType: 'json',
                    success: function(response) {
                        $this.remove('option');
                        jQuery('.lp-listing-sping').hide();
                        $this.append(response)
                    }
                })
            }
        })
    })
});
jQuery(document).ready(function($) {
    if (jQuery("#field_exclusive_field #exclusive_field").is(':checked')) {
        jQuery("#field-cat .check-all-btn").prop("disabled", !0);
        jQuery('#field-cat .single-check input[type=checkbox]').attr('checked', !1);
        jQuery('#field-cat .single-check input[type=checkbox]').prop("disabled", !0);
        jQuery("#field-cat").toggle("slow")
    } else {
        jQuery("#field-cat .check-all-btn").prop("disabled", !1);
        jQuery('#field-cat .single-check input[type=checkbox]').prop("disabled", !1)
    }
    jQuery("#field_exclusive_field #exclusive_field").on('click', function() {
        if (jQuery("#field_exclusive_field #exclusive_field").is(':checked')) {
            jQuery("#field-cat .check-all-btn").prop("disabled", !0);
            jQuery('#field-cat .single-check input[type=checkbox]').attr('checked', !1);
            jQuery('#field-cat .single-check input[type=checkbox]').prop("disabled", !0);
            jQuery("#field-cat").toggle("slow")
        } else {
            jQuery("#field-cat .check-all-btn").prop("disabled", !1);
            jQuery('#field-cat .single-check input[type=checkbox]').prop("disabled", !1);
            jQuery("#field-cat").toggle("slow")
        }
    })
});
jQuery(document).on('change', 'select[name="display_main_cats"]', function(e) {
    e.preventDefault();
    var parentID = jQuery(this).val();
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action': 'lp_get_child_cats',
            'parentID': parentID,
        },
        success: function(data) {
            var targetBoxesWrap = jQuery('[data-vc-shortcode-param-name="child_category_ids"]').find('.edit_form_line');
            targetBoxesWrap.html(data.markup)
        }
    })
});
jQuery(document).on('change', 'select[name="lp_price_plan_role"]', function() {
    $this = jQuery(this).val();
    if ($this == "claim-plan") {
        jQuery('#lp_select_parent_cats').slideToggle();
        jQuery('#lp_price_plan_bg').slideToggle();
        jQuery('#lp_field_lp_price_plan_addmore').slideToggle();
        jQuery('#plan_contact_box').slideToggle();
        jQuery('#plan_package_type').slideToggle();
        jQuery('#plan_color_box').slideToggle();
        jQuery('#plan_price_box').slideToggle();
        jQuery('#plan_time_box').slideToggle();
        jQuery('#plan_free_continue').slideToggle();
        jQuery('#plan_hot_box').slideToggle()
    } else {
        if (!jQuery('#plan_contact_box').is(':visible')) {
            jQuery('#lp_select_parent_cats').slideToggle();
            jQuery('#lp_price_plan_bg').slideToggle();
            jQuery('#lp_field_lp_price_plan_addmore').slideToggle();
            jQuery('#plan_contact_box').slideToggle();
            jQuery('#plan_package_type').slideToggle();
            jQuery('#plan_color_box').slideToggle();
            jQuery('#plan_price_box').slideToggle();
            jQuery('#plan_time_box').slideToggle();
            jQuery('#plan_free_continue').slideToggle();
            jQuery('#plan_hot_box').slideToggle()
        }
    }
});
jQuery(document).ready(function() {
    jQuery('.checkbox-all-btn').on('click', function() {
        $this = jQuery(this);
        $this.toggleClass('active');
        $currVal = $this.val();
        $prevVal = $this.data('clickval');
        $this.val($prevVal);
        $this.data('clickval', $currVal);
        if ($this.hasClass('active')) {
            $this.closest('div').find('input').prop("checked", !0)
        } else {
            $this.closest('div').find('input').prop("checked", !1)
        }
    });
    jQuery('#plan_duration_type select').on('change', function() {
        $this = jQuery(this);
        $duration = $this.find(':selected').data('days');
        jQuery('input#plan_time').val($duration)
    })
    if (jQuery('#plan_duration_type').length) {
        jQuery("input#plan_time").prop("disabled", !0);
        jQuery("input#plan_time").prop("readonly", !0);
        $duration = jQuery('#plan_duration_type select').find(':selected').data('days');
        jQuery('input#plan_time').val($duration)
    }
    jQuery('button#claim_actionBtn').on('click', function() {
        $this = jQuery(this);
        $this.toggleClass('active');
        if ($this.hasClass('active')) {
            $listing_id = jQuery('input[name=claimed_listing]').val();
            $claim_type = jQuery('select[name=claim_type]').val();
            $claim_plan = jQuery('select[name=claim_plan]').val();
            $claimer = jQuery('select[name=claimer]').val();
            $claim_post_ID = jQuery('input[name=post_ID]').val();
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: {
                    'action': 'lp_paid_claim_email_form',
                    'listing_id': $listing_id,
                    'claim_type': $claim_type,
                    'claim_plan': $claim_plan,
                    'claimer': $claimer,
                    'claim_post_ID': $claim_post_ID,
                },
                success: function(res) {
                    jQuery(res.htmlData).insertAfter('tr#claim_actionBtn')
                }
            })
        } else {
            jQuery('tr#lp_claim_email').remove()
        }
    })
    jQuery(document).on('click', 'button.lp_trigger_paidclaim_email', function() {
        $this = jQuery(this);
        $this.prop('disabled', !0);
        $claimer_id = jQuery('input[name=claimer_id]').val();
        $to_claimer_email = jQuery('input[name=to_claimer_email]').val();
        $email_subject = jQuery('input[name=email_subject]').val();
        $lp_claim_email = jQuery('textarea[name=lp_claim_email]').val();
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: {
                'action': 'lp_paid_claim_email_send',
                'claimer_id': $claimer_id,
                'to_claimer_email': $to_claimer_email,
                'email_subject': $email_subject,
                'lp_claim_email': $lp_claim_email,
            },
            success: function(res) {
                alert(res.msg);
                $this.prop('disabled', !1)
            }
        })
    })
    jQuery(document).on('change', 'select[name=field-type]', function() {
        var $this = jQuery(this);
        $checkSelected = $this.val();
        if ($checkSelected == "text") {
            jQuery('tr#lp-showin-filter').slideUp()
        } else {
            jQuery('tr#lp-showin-filter').slideDown()
        }
        jQuery('#lp_field_filter_type').val($this.val())
    });
    jQuery('#lp_field_filter_type').val(jQuery('select[name=field-type]').data('value'))
})
jQuery(window).load(function() {
    if (jQuery('select[name=field-type]').val() == "text") {
        jQuery('tr#lp-showin-filter').slideUp()
    } else {
        jQuery('tr#lp-showin-filter').slideDown()
    }
});
jQuery(document).ready(function() {
    jQuery('#show_add_coupons').click(function() {
        jQuery('.toggle_add_coupons').toggle(1000)
    });
    jQuery('.lp-bulkemail-form #cb-select-all-1').click(function() {
        if (jQuery(this).is(':checked')) {
            jQuery('input.lpauthermail').attr('name', 'author-mail[]');
            jQuery('input.lplistingauthermail').attr('name', 'listing-author-mail[]');
            jQuery('input.lplistingtitle').attr('name', 'lplistingtitle[]');
            jQuery('input.lplistingurl').attr('name', 'lplistingurl[]')
        } else {
            jQuery('input.lpauthermail').attr('name', '');
            jQuery('input.lplistingauthermail').attr('name', '');
            jQuery('input.lplistingtitle').attr('name', '');
            jQuery('input.lplistingurl').attr('name', '')
        }
    });
    jQuery('.lp-bulkemail-form .check-column input[type=checkbox]').click(function() {
        if (jQuery(this).is(':checked')) {
            jQuery(this).closest('tr').find('input.lpauthermail').attr('name', 'author-mail[]');
            jQuery(this).closest('tr').find('input.lplistingauthermail').attr('name', 'listing-author-mail[]');
            jQuery(this).closest('tr').find('input.lplistingtitle').attr('name', 'lplistingtitle[]');
            jQuery(this).closest('tr').find('input.lplistingurl').attr('name', 'lplistingurl[]')
        } else {
            jQuery(this).closest('tr').find('input.lpauthermail').attr('name', '');
            jQuery(this).closest('tr').find('input.lplistingauthermail').attr('name', '');
            jQuery(this).closest('tr').find('input.lplistingtitle').attr('name', '');
            jQuery(this).closest('tr').find('input.lplistingurl').attr('name', '')
        }
    });
    jQuery(document).on('click', 'button.lp-bulkmail-savetemplate', function() {
        $this = jQuery(this);
        $this.prop('disabled', !0);
        $email_subject = jQuery('input[name=email_subject]').val();
        $email_body = jQuery('textarea[name=email_body]').val();
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: {
                'action': 'lp_save_bulkemail_template',
                'email_subject': $email_subject,
                'email_body': $email_body,
            },
            success: function(res) {
                alert(res.msg);
                $this.prop('disabled', !1)
            }
        })
    });
    jQuery('ul.lpbackendtabs li').click(function() {
        var tab_id = $(this).attr('data-tab');
        jQuery('ul.lpbackendtabs li').removeClass('current');
        jQuery('.lp-backendtabs-content').removeClass('current');
        jQuery(this).addClass('current');
        jQuery("#" + tab_id).addClass('current')
    });
    jQuery(document).ready(function() {
        jQuery('.color-transparency-check').append(jQuery('<span class="slider round"></span>'))
    })
});

jQuery(document).on('change', '.lp_backend_inv_filter select', function(){
    var $method = jQuery('.lp_invoiceInput').val();
    var $status = jQuery('.lp_invoiceStatusInput').val();
    jQuery('table.wp-list-table tbody').html('');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action': 'lp_filter_backend_invoice',
            'method': $method,
            'status': $status,
        },
        success: function(res) {
            //alert(res);
            jQuery('table.wp-list-table tbody').append(res);
        }
    })
});