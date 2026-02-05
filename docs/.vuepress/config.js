import { viteBundler } from '@vuepress/bundler-vite'
import { defaultTheme } from '@vuepress/theme-default'
import { defineUserConfig } from 'vuepress'

const isProd = process.env.NODE_ENV === 'production'

export default defineUserConfig({
  lang: 'en-GB',
  title: 'Local Mangaplus',
  description: 'A dedicated MangaPlus monitor that automatically fetches your bookmarked chapters the second they are published. No more manual checking - just sync and read.',
  base: isProd ? '/local-mangaplus/' : '/',
  bundler: viteBundler(),
  theme: defaultTheme({
    repo: 'https://github.com/Treast/local-mangaplus',
    navbar: [
      {
        text: 'Home',
        link: '/',
      },
      {
        text: 'Guide',
        collapsed: false,
        children: [
          {
            text: 'Introduction',
            link: '/guide/introduction.md',
          },
          {
            text: 'Installation',
            link: '/guide/installation.md',
          },
          {
            text: 'Architecture',
            link: '/guide/architecture.md',
          },
        ]
      }
    ],
    sidebar: [
      {
        text: 'Guide',
        children: [
          {
            text: 'Introduction',
            link: '/guide/introduction.md',
          },
          {
            text: 'Installation',
            link: '/guide/installation.md',
          },
          {
            text: 'Architecture',
            link: '/guide/architecture.md',
          },
        ]
      },
      {
        text: 'Development',
        children: [
          {
            text: 'Contributing',
            link: '/development/contributing.md',
          },
          {
            text: 'Roadmap',
            link: '/development/roadmap.md',
          },
        ]
      }
    ],
  }),
})
