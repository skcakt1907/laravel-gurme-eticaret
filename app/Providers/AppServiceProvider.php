<?php

namespace App\Providers;

use App\Models\Category;
use App\Support\Cart;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('navCategories', Category::active()->whereNull('parent_id')->orderBy('sira')->get());
            $view->with('cartCount', Cart::count());
        });

        // Kayıt sonrası e-posta doğrulama maili — müşterinin diline göre TR/EN
        VerifyEmail::toMailUsing(function ($notifiable, string $url) {
            $marka = setting('site_adi');

            if (app()->getLocale() === 'tr') {
                return (new MailMessage)
                    ->subject('E-posta Adresinizi Doğrulayın — '.$marka)
                    ->greeting('Merhaba '.$notifiable->name.',')
                    ->line($marka.' ailesine hoş geldiniz. Hesabınızı etkinleştirmek için aşağıdaki butona tıklayarak e-posta adresinizi doğrulayın.')
                    ->action('E-postamı Doğrula', $url)
                    ->line('Bu bağlantı 60 dakika geçerlidir.')
                    ->line('Kayıt olmadıysanız bu e-postayı yok sayabilirsiniz.')
                    ->salutation('Sevgilerle, '.$marka);
            }

            return (new MailMessage)
                ->subject('Verify Your Email — '.$marka)
                ->greeting('Hello '.$notifiable->name.',')
                ->line('Welcome to '.$marka.'. Please confirm your email address by clicking the button below to activate your account.')
                ->action('Verify My Email', $url)
                ->line('This link is valid for 60 minutes.')
                ->line('If you did not create an account, you can safely ignore this email.')
                ->salutation('Warm regards, '.$marka);
        });

        // Şifre sıfırlama e-postasını Türkçeleştir
        ResetPassword::toMailUsing(function ($notifiable, string $token) {
            $url = route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()]);

            return (new MailMessage)
                ->subject('Password Reset — ' . setting('site_adi'))
                ->greeting('Hello,')
                ->line('We received a request to reset the password for your account. Click the button below to set a new password.')
                ->action('Reset Password', $url)
                ->line('This link will expire in ' . config('auth.passwords.users.expire', 60) . ' minutes.')
                ->line('If you did not request this, no action is needed.')
                ->salutation('Best regards, ' . setting('site_adi'));
        });
    }
}
