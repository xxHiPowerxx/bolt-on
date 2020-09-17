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
			var $parent = $(this).closest('.wpcf7'),
			$target = $parent.find('.selectHiddenOptionTar'),
			that = this;
			function coreFunc(that, event) {
				var practiceArea = that.value,
				mailRecipient = postsData[practiceArea];
				console.log('postsData[practiceArea]', postsData[practiceArea]);
				if ( postsData[practiceArea] !== undefined ) {
					// If Event is submit, decrypt string;
					if ( event.type === 'wpcf7submit' ) {
						var key = reverseString(practiceArea);
						mailRecipient = cryptoJsAES.decrypt(key, mailRecipient);
						console.log('mailRecipient after decrypt', mailRecipient);
					}
					$target.val( mailRecipient );
				} else {
					$target.val('');
				}
				console.log('$target.val()', $target.val());
			}
			$(this).on('change', function(){
				// use 'this' here because it's quicker than 'that'
				// even though 'that' === 'this';
				coreFunc(this);
			});
			$parent.on('wpcf7submit', function (event) {
				console.log('event', event);
				$target.prop('disabled', false);
				coreFunc(that, event);
			}).on('wpcf7mailsent', function(){
				console.log('here');
				setTimeout(function(){
					$target.prop('disabled', true);
				}, 100);
			});
		});
	}
	function readyFuncs() {
		selectHiddenOption();
	}
	readyFuncs();
});