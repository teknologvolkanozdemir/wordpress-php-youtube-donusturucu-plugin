# İndir

WordPress için YouTube video gömme ve yetkili olduğunuz MP3/MP4 dosyalarına indirme bağlantısı ekleme eklentisi. YouTube videolarını indirmez veya dönüştürmez. YouTube'dan alınan videoların indirilmesi ya da dönüştürülmesi yerine, yalnızca indirme ve paylaşma hakkına sahip olduğunuz medya dosyalarının doğrudan bağlantılarını kullanın.

## Kurulum

1. `indir.php` dosyasını `wp-content/plugins/indir/` klasörüne yükleyin.
2. WordPress yönetim panelinde **Eklentiler** bölümünden **İndir** eklentisini etkinleştirin.
3. Bir yazı veya sayfaya aşağıdaki kısa kodu ekleyin:

```text
[indir youtube="https://www.youtube.com/watch?v=dQw4w9WgXcQ" mp3="https://example.com/audio.mp3" mp4="https://example.com/video.mp4"]
```

`youtube`, `mp3` ve `mp4` özellikleri isteğe bağlıdır. YouTube bağlantısı video oynatıcısını gömer; MP3 ve MP4 bağlantıları doğrudan dosyalarınıza yönelir. Bağlantılarda yalnızca `http` ve `https` adresleri kabul edilir. Bir dosya bağlantısının gerçek indirme davranışı, tarayıcı ve dosyanın barındırıldığı sunucunun ayarlarına bağlı olabilir.
