jQuery(document).ready(function($) {
	var cryptoJsAES = {
		encrypt: function(passphrase, valueToEncrypt) {
			var CryptoJSAesJson = {
				stringify: function (cipherParams) {
					var j = {ct: cipherParams.ciphertext.toString(CryptoJS.enc.Base64)};
					if (cipherParams.iv) j.iv = cipherParams.iv.toString();
					if (cipherParams.salt) j.s = cipherParams.salt.toString();
					return JSON.stringify(j);
				}
			};
			return CryptoJS.AES.encrypt(JSON.stringify(valueToEncrypt), passphrase, {format: CryptoJSAesJson}).toString();
		},
		decrypt: function(passphrase, encrypted) {
			var CryptoJSAesJson = {
				parse: function (jsonStr) {
					var j = JSON.parse(jsonStr);
					var cipherParams = CryptoJS.lib.CipherParams.create({ciphertext: CryptoJS.enc.Base64.parse(j.ct)});
					if (j.iv) cipherParams.iv = CryptoJS.enc.Hex.parse(j.iv)
					if (j.s) cipherParams.salt = CryptoJS.enc.Hex.parse(j.s)
					return cipherParams;
				}
			}
			return JSON.parse(CryptoJS.AES.decrypt(encrypted, passphrase, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
		}
	};
	function reverseString(str) {
		return (str === '') ? '' : reverseString(str.substr(1)) + str.charAt(0);
	}
	// Select hidden Option on change.
	function selectHiddenOption() {
		var $selectHiddenOption = $('.selectHiddenOption');
		$selectHiddenOption.each(function() {
			var $wpcf7 = $(this).closest('.wpcf7'),
			$form = $(this).closest('form'),
			$target = $wpcf7.find('.selectHiddenOptionTar'),
			targetName,
			that = this,
			mailRecipient,
			dMailRecipient;
			if ($target.length) {
				targetName = $target.attr('name');
			}
			function coreFunc(that, event, $that) {
				var practiceArea = that.value;
				mailRecipient = postsData[practiceArea];
				// console.log('that.value', that.value);
				console.log('postsData[practiceArea]', postsData[practiceArea]);
				if ( postsData[practiceArea] !== undefined ) {
					// If Event is submit, decrypt string;
					// console.log(event);
					if ( event !== undefined && event.type === 'submit' ) {
						var key = reverseString(practiceArea),
						dMailRecipient = cryptoJsAES.decrypt(key, mailRecipient);
						console.log('mailRecipient after decrypt', dMailRecipient);
						// Set $target val to decrypted mailRecipient.
						$target.val( dMailRecipient );
					} else {
						$target.val( mailRecipient );
					}
				} else {
					$target.val('');
				}
				if ( $that !== undefined && $that.is($form) ) {
					$form.trigger('coreFunc');
				}
				console.log('$target.val() at end of coreFunc()', $target.val());
			}
			$(this).on('change', function(){
				// use 'this' here because it's quicker than 'that'
				// even though 'that' === 'this';
				coreFunc(this);
			});
			$form.submit(function (event) {
				if ( event.boltOnStopped === undefined ) {
					event.stopImmediatePropagation();
					event.preventDefault();
					console.log('$form submit');
					$target.prop('disabled', false);
					this.cachedSubmit = event;
					coreFunc(that, event, $(this));
				}
			}).on('coreFunc', function(event){
				// event.boltOnStopped = true;
				console.log(this);
				console.log('this.cachedSubmit', this.cachedSubmit);
				$(this).trigger(this.cachedSubmit);
			});
			$wpcf7.on('wpcf7mailsent', function(event){
				// console.log('wpcf7mailsent', event);
				// Trigger decryptedSent with encrypted mailRecipient.
				// $(this).trigger('decryptedSent', [mailRecipient]);
				console.log('$target.val() on wpcf7mailsent', $target.val());
				var inputsArray = event.detail.inputs;
				inputsArray.filter(function(obj) {
					if (obj.name === targetName) {
						return obj.value = dMailRecipient;
					}
				});
				console.log('inputsArray', inputsArray);
				console.log('wpcf7mailsent', event);

				var $that = $(this);
				setTimeout(function(){
					// $that.trigger('decryptedSent', [mailRecipient]);
					console.log('$target.val() on wpcf7mailsent setTimeout', $target.val());
				;
				// 	$target.prop('disabled', true);
				}, 1000);
			}).on('decryptedSent', function(event, mailRecipient) {

				$target.val( mailRecipient );
				console.log('$target.val( mailRecipient )', $target.val());
			});
		});
	}
	function readyFuncs() {
		selectHiddenOption();
	}
	readyFuncs();
});