<?php
class Event
{

  const DAYS = ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'];
  const ROOTDIR = '/var/www/vhosts/hosting1234.af90a.netcup.net/httpdocs/';

  protected $id;
  protected $timestamp, $name, $text, $category, $picturePath;

  /**
   * display an event
   * requires basicLightbox.js to show large image on click
   *
   * @param integer $id
   * @param string $timestamp
   * @param string $name
   * @param string $text
   * @param string $category
   * @param string $picturePath an imageName_1080.extension must also exist 
   * in the same location
   * @return Event
   */
  public function __construct(
    int $id,
    string $timestamp,
    string $name,
    string $text,
    string $category,
    string $picturePath
  ) {
    $this->id = $id;
    $this->timestamp = $timestamp;
    $this->name = $name;
    $this->category = $category;
    $this->text = $text;
    $this->picturePath = $picturePath;
    return $this;
  }

  private function image(bool $lazy = True): string
  {
    // if (!file_exists(static::ROOTDIR . "/" . $this->picturePath)) {
    //     return '';
    // }
    $path = pathinfo($this->picturePath);
    $loading = $lazy ? 'loading="lazy"' : "";
    return <<<HTML
          <img src="{$this->picturePath}" {$loading} alt="{$this->name} plakat" width="200" height="200" 
            style="height: auto;" 
            onclick= 'const instance = basicLightbox.create(`<img src="{$this->highQualityImageLink()}">`); instance.show()'>
HTML;
  }

  private function highQualityImageLink(): string
  {
    $path = pathinfo($this->picturePath);
    return $path['dirname'] . "/" . $path['filename'] . "_1080." . $path['extension'];
  }

  /**
   * render script tag with event schema json
   *
   * @return string
   */
  public function schema(): string
  {
    $rawtext = json_encode(strip_tags($this->text));
    $time = date('Y-m-jTG:i', $this->timestamp);
    $idLink = str_replace(" ", "-", $this->name);
    return <<<HTML
            <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "Event",
              "name": "$this->name",
              "startDate": "$time",
              "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
              "eventStatus": "https://schema.org/EventScheduled",
              "location": {
                "@type": "Place",
                "name": "Studentenzentrum Z10",
                "address": {
                  "@type": "PostalAddress",
                  "streetAddress": "Zähringerstraße 10",
                  "addressLocality": "Karlsruhe",
                  "postalCode": "76149",
                  "addressRegion": "BW",
                  "addressCountry": "DE"
                }
              },
              "image": [
                "https://z10.info/{$this->highQualityImageLink()}"
               ],
              "description": $rawtext,
              "organizer": {
                "@type": "Organization",
                "name": "Studentenzentrum Z10 e. V. Karlsruhe",
                "url": "https://z10.info/#$idLink"
              }
            }
          </script>
HTML;
  }

  public function render(bool $lazyLoadingImage = True, bool $renderSchema = false)
  {

    $if = function ($condition, $true, $false) {
      return $condition ? $true : $false;
    };

    $text = preg_replace(
      '/\s(www\.)(\S+)/',
      '<a href="https://\\1\\2" target="_blank">\\1\\2</a>',
      $this->text
    );
    $zeit = static::DAYS[date('w', $this->timestamp)] . ', ' . date('j.m.Y - G:i', $this->timestamp);
    $idLink = str_replace(" ", "-", $this->name);

    return <<<HTML
   <div class="dates" id="$idLink">
      <div class="dateheader">
         <div class="datestamp">$zeit</div>
         <div class="datename">$this->name <span class="datecategory">($this->category)</span>
            <a href="/termineics?event={$this->id}" rel="nofollow">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="transform: translateY(7px);" viewBox="0 0 24 24"><path fill="currentColor" d="M17 22v-3h-3v-2h3v-3h2v3h3v2h-3v3h-2ZM5 20q-.825 0-1.413-.588T3 18V6q0-.825.588-1.413T5 4h1V2h2v2h6V2h2v2h1q.825 0 1.413.588T19 6v6.1q-.5-.075-1-.075t-1 .075V10H5v8h7q0 .5.075 1t.275 1H5ZM5 8h12V6H5v2Zm0 0V6v2Z"/></svg>
            </a></div>
      </div>
      <div class="dateimage">{$this->image($lazyLoadingImage)}</div>
      <div class="datetext">
      $text
      </div>
      {$if($renderSchema,$this->schema(), "")}
   </div>
HTML;
  }

  public function editable(bool $lazyLoadingImage = True)
  {
    $text = preg_replace(
      '/\s(www\.)(\S+)/',
      '<a href="https://\\1\\2" target="_blank">\\1\\2</a>',
      $this->text
    );
    $zeit = date('Y-m-d G:i', $this->timestamp);
    $idLink = str_replace(" ", "-", $this->name);

    return <<<HTML
       <div class="dates" id="$idLink">
      <div class="dateheader">
         <div class="datestamp"><input type="datetime-local" value="{$zeit}"></div>
         <div class="datename"><span contenteditable tabindex=1>$this->name</span> (<select>
          <option>$this->category</option>
         </select>) 
            <a href="/termineics?event={$this->id}">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="transform: translateY(7px);" viewBox="0 0 24 24"><path fill="currentColor" d="M17 22v-3h-3v-2h3v-3h2v3h3v2h-3v3h-2ZM5 20q-.825 0-1.413-.588T3 18V6q0-.825.588-1.413T5 4h1V2h2v2h6V2h2v2h1q.825 0 1.413.588T19 6v6.1q-.5-.075-1-.075t-1 .075V10H5v8h7q0 .5.075 1t.275 1H5ZM5 8h12V6H5v2Zm0 0V6v2Z"/></svg>
            </a></div>
      </div>
      <div class="dateimage">{$this->image($lazyLoadingImage)}</div>
      <div class="datetext" contenteditable=1 tabindex=1>
      $text
      </div>
   </div>
HTML;
  }
}
