<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use Illuminate\Translation\PotentiallyTranslatedString;

/**
 * Blocks known disposable/burner email providers on public-facing forms
 * (newsletter signup, contact form) — this app has no external API budget
 * or dependency for this, so it's a maintained static domain list rather
 * than a live lookup service. Not exhaustive (new disposable domains
 * appear constantly), but covers the large majority of well-known ones
 * real spam/abuse traffic actually uses.
 */
class NotDisposableEmail implements ValidationRule
{
    /**
     * @var array<int, string>
     */
    private const BLOCKED_DOMAINS = [
        '0-mail.com', '0815.ru', '0clickemail.com', '10minutemail.com', '10minutemail.net',
        '10minutemail.org', '123mail.org', '1secmail.com', '1secmail.net', '1secmail.org',
        '20minutemail.com', '2prong.com', '33mail.com', '3trtretgfrhrtgh.com', '4warding.com',
        '5mail.cf', '5mail.ga', '60minutemail.com', '675hosting.com', '6paq.com',
        '7tags.com', '9ox.net', 'anonbox.net', 'anonymbox.com', 'antichef.com',
        'antichef.net', 'antireg.ru', 'antispam.de', 'baxomale.ht.cx', 'beefmilk.com',
        'binkmail.com', 'bio-muesli.net', 'bobmail.info', 'bodhi.lawlita.com', 'boun.cr',
        'bugmenot.com', 'bumpymail.com', 'burnermail.io', 'burnthespam.info', 'buymoreplays.com',
        'byom.de', 'chammy.info', 'childsavetrust.org', 'chogmail.com', 'choicemail1.com',
        'clixser.com', 'cool.fr.nf', 'correo.blogos.net', 'cosmorph.com', 'courriel.fr.nf',
        'cubiclink.com', 'curryworld.de', 'cust.in', 'dacoolest.com', 'dandikmail.com',
        'dayrep.com', 'deadaddress.com', 'deadchildren.org', 'deagot.com', 'despam.it',
        'devnullmail.com', 'dfgh.net', 'digitalsanctuary.com', 'discardmail.com', 'discardmail.de',
        'disposable.com', 'disposableaddress.com', 'disposableemailaddresses.com', 'disposableinbox.com', 'dispose.it',
        'dispostable.com', 'dodgeit.com', 'dodgit.com', 'dodgit.org', 'donemail.ru',
        'dontreg.com', 'dontsendmespam.de', 'drdrb.net', 'dumpandjunk.com', 'dumpmail.de',
        'dumpyemail.com', 'e4ward.com', 'easytrashmail.com', 'einrot.com', 'emailias.com',
        'emailinfive.com', 'emailmiser.com', 'emailsensei.com', 'emailtemporario.com.br', 'emailthe.net',
        'emailtmp.com', 'emailwarden.com', 'emailx.at.hm', 'emailxfer.com', 'emeil.in',
        'emeil.ir', 'emz.net', 'ero-tube.org', 'evopo.com', 'explodemail.com',
        'express.net.ua', 'eyepaste.com', 'fakeinbox.com', 'fakeinformation.com', 'fansworldwide.de',
        'fantasymail.de', 'fastacura.com', 'fastkawasaki.com', 'fastmazda.com', 'fastmessaging.com',
        'fastyamaha.com', 'fatflap.com', 'filzmail.com', 'fizmail.com', 'fleckens.hu',
        'frapmail.com', 'front14.org', 'fux0ringduh.com', 'garliclife.com', 'get1mail.com',
        'get2mail.fr', 'getairmail.com', 'getonemail.com', 'ghosttexter.de', 'giantmail.de',
        'girlsundertheinfluence.com', 'gishpuppy.com', 'gowikibooks.com', 'gowikicampus.com', 'gowikicars.com',
        'gowikifilms.com', 'gowikigames.com', 'gowikimusic.com', 'gowikinetwork.com', 'gowikitravel.com',
        'gowikitv.com', 'great-host.in', 'greensloth.com', 'grr.la', 'gsrv.co.uk',
        'guerrillamail.biz', 'guerrillamail.com', 'guerrillamail.de', 'guerrillamail.info', 'guerrillamail.net',
        'guerrillamail.org', 'guerrillamailblock.com', 'gustr.com', 'harakirimail.com', 'hat-geld.de',
        'hidemail.de', 'hidzz.com', 'hmamail.com', 'hopemail.biz', 'ieatspam.eu',
        'ieatspam.info', 'ihateyoualot.info', 'imails.info', 'inboxalias.com', 'inboxclean.com',
        'inboxclean.org', 'infocom.zp.ua', 'insorg-mail.info', 'instant-mail.de', 'ipoo.org',
        'irish2me.com', 'iwi.net', 'jetable.com', 'jetable.fr.nf', 'jetable.net',
        'jetable.org', 'jnxjn.com', 'jourrapide.com', 'junk1e.com', 'kasmail.com',
        'kaspop.com', 'keepmymail.com', 'killmail.com', 'killmail.net', 'kir.ch.tc',
        'klassmaster.com', 'klzlk.com', 'koszmail.pl', 'kurzepost.de', 'lawlita.com',
        'letthemeatspam.com', 'lhsdv.com', 'lifebyfood.com', 'link2mail.net', 'litedrop.com',
        'lookugly.com', 'lopl.co.cc', 'lortemail.dk', 'lr78.com', 'lroid.com',
        'lukop.dk', 'm21.cc', 'mail-filter.com', 'mail-temporaire.fr', 'mail.by',
        'mail.mezimages.net', 'mail1a.de', 'mail21.cc', 'mail2rss.org', 'mail333.com',
        'mail4trash.com', 'mailbidon.com', 'mailbiz.biz', 'mailblocks.com', 'mailcatch.com',
        'maildrop.cc', 'maildx.com', 'maileater.com', 'mailexpire.com', 'mailfa.tk',
        'mailforspam.com', 'mailfreeonline.com', 'mailguard.me', 'mailimate.com', 'mailin8r.com',
        'mailinatar.com', 'mailinater.com', 'mailinator.com', 'mailinator.net', 'mailinator.org',
        'mailinator2.com', 'mailincubator.com', 'mailismagic.com', 'mailme.lv', 'mailme24.com',
        'mailmetrash.com', 'mailmoat.com', 'mailms.com', 'mailnesia.com', 'mailnull.com',
        'mailorg.org', 'mailpick.biz', 'mailrock.biz', 'mailscrap.com', 'mailshell.com',
        'mailsiphon.com', 'mailslapping.com', 'mailslite.com', 'mailtemp.info', 'mailtome.de',
        'mailtothis.com', 'mailtrash.net', 'mailtv.net', 'mailtv.tv', 'mailzilla.com',
        'mailzilla.org', 'mbx.cc', 'mega.zik.dj', 'meltmail.com', 'messagebeamer.de',
        'mierdamail.com', 'mintemail.com', 'mjukglass.nu', 'mobileninja.co.uk', 'moburl.com',
        'moncourrier.fr.nf', 'monemail.fr.nf', 'monmail.fr.nf', 'msa.minsmail.com', 'mt2009.com',
        'mt2014.com', 'mt2015.com', 'mycard.net.ua', 'mycleaninbox.net', 'mypacks.net',
        'mypartyclip.de', 'myphantomemail.com', 'myspaceinc.com', 'myspaceinc.net', 'myspaceinc.org',
        'myspacepimpedup.com', 'myspamless.com', 'mytemp.email', 'mytempemail.com', 'mytempmail.com',
        'mytrashmail.com', 'neomailbox.com', 'nepwk.com', 'nervmich.net', 'nervtmich.net',
        'netmails.com', 'netmails.net', 'netzidiot.de', 'neverbox.com', 'nice-4u.com',
        'nincsmail.hu', 'nnh.com', 'no-spam.ws', 'noblepioneer.com', 'nomail.xl.cx',
        'nomail2me.com', 'nomorespamemails.com', 'nospam.ze.tc', 'nospam4.us', 'nospamfor.us',
        'nospammail.net', 'notmailinator.com', 'nowmymail.com', 'nurfuerspam.de', 'nus.edu.sg',
        'nwldx.com', 'objectmail.com', 'obobbo.com', 'odaymail.com', 'oneoffemail.com',
        'onewaymail.com', 'onlatedotcom.info', 'online.ms', 'opayq.com', 'ordinaryamerican.net',
        'otherinbox.com', 'ovpn.to', 'owlpic.com', 'pancakemail.com', 'pcusers.otherinbox.com',
        'pjjkp.com', 'plexolan.de', 'poofy.org', 'pookmail.com', 'privacy.net',
        'privatdemail.net', 'proxymail.eu', 'punkass.com', 'putthisinyourspamdatabase.com', 'pwrby.com',
        'quickinbox.com', 'rcpt.at', 'reallymymail.com', 'realtyalerts.ca', 'recode.me',
        'recursor.net', 'recyclemail.dk', 'regbypass.com', 'regbypass.comsafe-mail.net', 'rejectmail.com',
        'rhyta.com', 'rmqkr.net', 'royal.net', 'rppkn.com', 'rtrtr.com',
        's0ny.net', 'safe-mail.net', 'safersignup.de', 'safetymail.info', 'safetypost.de',
        'sandelf.de', 'saynotospams.com', 'selfdestructingmail.com', 'sendspamhere.com', 'sharklasers.com',
        'shieldedmail.com', 'shiftmail.com', 'shitmail.me', 'shitware.nl', 'shortmail.net',
        'sibmail.com', 'sinnlos-mail.de', 'siteposter.net', 'skeefmail.com', 'slapsfromlastnight.com',
        'slaskpost.se', 'smashmail.de', 'smellfear.com', 'snakemail.com', 'sneakemail.com',
        'sofimail.com', 'sofort-mail.de', 'sogetthis.com', 'soodonims.com', 'spam.la',
        'spam.su', 'spam4.me', 'spamavert.com', 'spambob.com', 'spambob.net',
        'spambob.org', 'spambog.com', 'spambog.de', 'spambog.ru', 'spambox.info',
        'spambox.us', 'spamcannon.com', 'spamcannon.net', 'spamcero.com', 'spamcon.org',
        'spamcorptastic.com', 'spamcowboy.com', 'spamcowboy.net', 'spamcowboy.org', 'spamday.com',
        'spamex.com', 'spamfree24.com', 'spamfree24.de', 'spamfree24.eu', 'spamfree24.info',
        'spamfree24.net', 'spamfree24.org', 'spamgoes.in', 'spamherelots.com', 'spamhereplease.com',
        'spamhole.com', 'spamify.com', 'spaminator.de', 'spamkill.info', 'spaml.com',
        'spaml.de', 'spammotel.com', 'spamobox.com', 'spamoff.de', 'spamsalad.in',
        'spamslicer.com', 'spamspot.com', 'spamstack.net', 'spamthis.co.uk', 'spamthisplease.com',
        'spamtroll.net', 'speed.1s.fr', 'spikio.com', 'spoofmail.de', 'spybox.de',
        'squizzy.de', 'ssoia.com', 'startkeys.com', 'stinkefinger.net', 'stop-my-spam.com',
        'streetwisemail.com', 'stuffmail.de', 'super-auswahl.de', 'supergreatmail.com', 'supermailer.jp',
        'superrito.com', 'suremail.info', 'svk.jp', 'sweetxxx.de', 'tafmail.com',
        'tagyourself.com', 'talkinator.com', 'tapchicuoihoi.com', 'teewars.org', 'teleworm.com',
        'teleworm.us', 'temp-mail.com', 'temp-mail.org', 'temp-mail.ru', 'tempalias.com',
        'tempe-mail.com', 'tempemail.biz', 'tempemail.com', 'tempemail.net', 'tempinbox.co.uk',
        'tempinbox.com', 'tempmail.eu', 'tempmail.it', 'tempmail2.com', 'tempmaildemo.com',
        'tempmailer.com', 'tempmailer.de', 'tempomail.fr', 'temporarily.de', 'temporarioemail.com.br',
        'temporaryemail.net', 'temporaryemail.us', 'temporaryforwarding.com', 'temporaryinbox.com', 'temporarymailaddress.com',
        'tempsky.com', 'tempthe.net', 'thanksnospam.info', 'thankyou2010.com', 'thc.st',
        'thecloudindex.com', 'thelimestones.com', 'thisisnotmyrealemail.com', 'throam.com', 'throwawayemailaddress.com',
        'throwawaymail.com', 'tilien.com', 'tittbit.in', 'tizi.com', 'tmail.ws',
        'tmailinator.com', 'toiea.com', 'tradermail.info', 'trash-amil.com', 'trash-mail.at',
        'trash-mail.com', 'trash-mail.de', 'trash2009.com', 'trashdevil.com', 'trashemail.de',
        'trashmail.at', 'trashmail.com', 'trashmail.de', 'trashmail.me', 'trashmail.net',
        'trashmail.org', 'trashmail.ws', 'trashmailer.com', 'trashymail.com', 'trashymail.net',
        'trbvm.com', 'trialmail.de', 'trickmail.net', 'trillianpro.com', 'tryalert.com',
        'turual.com', 'twinmail.de', 'tyldd.com', 'uggsrock.com', 'umail.net',
        'upliftnow.com', 'uplipht.com', 'uroid.com', 'us.af', 'venompen.com',
        'veryrealemail.com', 'vidchart.com', 'viditag.com', 'viewcastmedia.com', 'viewcastmedia.net',
        'viewcastmedia.org', 'vpn.st', 'vsimcard.com', 'vubby.com', 'wasteland.rfc822.org',
        'watchfull.net', 'webemail.me', 'weg-werf-email.de', 'wegwerf-email-addressen.de', 'wegwerf-emails.de',
        'wegwerfadresse.de', 'wegwerfemail.com', 'wegwerfemail.de', 'wegwerfmail.de', 'wegwerfmail.info',
        'wegwerfmail.net', 'wegwerfmail.org', 'wetrainbayarea.com', 'wetrainbayarea.org', 'wh4f.org',
        'whatiaas.com', 'whatpaas.com', 'whatsaas.com', 'whopy.com', 'whyspam.me',
        'willselfdestruct.com', 'winemaven.info', 'wronghead.com', 'wuzup.net', 'wuzupmail.net',
        'www.e4ward.com', 'www.gishpuppy.com', 'www.mailinator.com', 'wwwnew.eu', 'xagloo.com',
        'xemaps.com', 'xents.com', 'xmaily.com', 'xoxy.net', 'yep.it',
        'yogamaven.com', 'yopmail.com', 'yopmail.fr', 'yopmail.net',
        'ypmail.webarnak.fr.eu.org', 'yuurok.com', 'zehnminuten.de', 'zehnminutenmail.de', 'zippymail.info',
        'zoaxe.com', 'zoemail.net', 'zomg.info',
    ];

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! str_contains($value, '@')) {
            return;
        }

        $domain = Str::lower(Str::after($value, '@'));

        if (in_array($domain, self::BLOCKED_DOMAINS, true)) {
            $fail('Please use a permanent email address — disposable/temporary email addresses aren\'t accepted.');
        }
    }
}
