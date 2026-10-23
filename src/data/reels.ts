// Hero strip: client testimonials (two) plus AI, concept and CGI videos from wiseup.in/portfolio. Each card keeps
// shape (ar = width / height): portrait reels whole at 9:16, landscape films in a 4:3 card (a light side crop). Videos stream from wiseup.in and load only
// when a card plays. Posters: testimonials use the WordPress site's own WebPs; the rest are frames grabbed from
// the videos (public/strip/*.webp, 720px tall).
const UP = 'https://wiseup.in/wp-content/uploads';

export type Reel = { label: string; title: string; poster: string; srcset?: string; video: string; ar: number };

const testimonial = (title: string, name: string, file: string): Reel => ({
  label: 'Testimonial', title,
  poster: `${UP}/2026/06/${name}-576x1024.webp`,
  srcset: [169, 576, 768].map((w) => `${UP}/2026/06/${name}-${w}x${Math.round(w * 1.7778)}.webp ${w}w`).join(', '),
  video: `${UP}/2026/07/${file}.mp4`, ar: 9 / 16,
});
const work = (label: string, title: string, poster: string, file: string, ar: number): Reel => ({
  label, title, poster: `/strip/${poster}.webp`, video: `${UP}/${file}.mp4`, ar,
});

export const reels: Reel[] = [
  testimonial('Sajeev Nair', 'SAJEEV-NAIR', 'Sajeev-Nair-Testimoni-compressed'),
  work('AI video', 'Adipoli Onam', 'onam', '2026/07/Adipoli-Onam2', 4 / 3),
  work('AI video', 'AI branding', 'ai-branding', '2026/08/Ai-branding-video', 9 / 16),
  work('CGI', 'Sathya CGI', 'cgi-1', '2026/08/WhatsApp-Video-2026-07-28-at-5.34.53-PM-2', 9 / 16),
  work('Concept video', 'Maveli Returns', 'maveli', '2026/07/Sathya-MAVELI-Returns', 4 / 3),
  work('AI video', 'Bootland', 'bootland', '2026/08/Boootland', 9 / 16),
  testimonial('TR Shamsudheen', 'tr-shamsudheen', 'TR-Shamsudheen-Testimonial-1-compressed'),
  work('AI video', 'Kollam teaser', 'kollam', '2026/08/Kollam-Teaser', 4 / 3),
  work('Concept video', 'Chayakkada', 'chayakkada', '2026/08/Chayakkada-1-compressed', 9 / 16),
  work('CGI', 'Soulfactors juice', 'abc-juice', '2026/08/ABC-juice-Soulfactors-Final-002-compressed', 4 / 3),
  work('AI video', 'Cellar', 'cellar', '2026/08/CELLAR-AI-video-02', 9 / 16),
  work('CGI', 'Sathya store', 'cgi-2', '2026/08/WhatsApp-Video-2026-07-28-at-5.34.53-PM-3', 9 / 16),
];
