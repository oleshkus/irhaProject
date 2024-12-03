import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            typography: {
                DEFAULT: {
                    css: {
                        color: '#374151',
                        maxWidth: 'none',
                        h1: {
                            color: '#111827',
                            fontWeight: '700',
                            fontSize: '1.7em',
                            marginTop: '0',
                            marginBottom: '0.75em',
                            lineHeight: '1.2'
                        },
                        h2: {
                            color: '#111827',
                            fontWeight: '600',
                            fontSize: '1.5em',
                            marginTop: '1.75em',
                            marginBottom: '0.75em',
                            lineHeight: '1.2'
                        },
                        h3: {
                            color: '#111827',
                            fontWeight: '600',
                            fontSize: '1.25em',
                            marginTop: '1.5em',
                            marginBottom: '0.5em',
                            lineHeight: '1.3'
                        },
                        p: {
                            marginTop: '0.75em',
                            marginBottom: '0.75em',
                            lineHeight: '1.5'
                        },
                        a: {
                            color: '#2563eb',
                            textDecoration: 'underline',
                            fontWeight: '500',
                            '&:hover': {
                                color: '#1d4ed8'
                            }
                        },
                        ul: {
                            marginTop: '0.75em',
                            marginBottom: '0.75em',
                            paddingLeft: '1.25em',
                            listStyle: 'disc outside',
                            li: {
                                marginTop: '0.25em',
                                marginBottom: '0.25em',
                                paddingLeft: '0.375em'
                            },
                            'li::marker': {
                                color: '#6B7280'
                            }
                        },
                        ol: {
                            marginTop: '0.75em',
                            marginBottom: '0.75em',
                            paddingLeft: '1.25em',
                            listStyle: 'decimal outside',
                            li: {
                                marginTop: '0.25em',
                                marginBottom: '0.25em',
                                paddingLeft: '0.375em'
                            },
                            'li::marker': {
                                color: '#374151',
                                fontWeight: '500'
                            }
                        },
                        blockquote: {
                            fontWeight: '500',
                            fontStyle: 'italic',
                            color: '#111827',
                            borderLeftWidth: '0.25rem',
                            borderLeftColor: '#e5e7eb',
                            marginTop: '1.25em',
                            marginBottom: '1.25em',
                            paddingLeft: '1em'
                        },
                        img: {
                            marginTop: '0.75em',
                            marginBottom: '0.75em',
                            borderRadius: '0.375rem'
                        },
                        strong: {
                            color: '#111827',
                            fontWeight: '600'
                        },
                        code: {
                            color: '#111827',
                            fontWeight: '600',
                            fontSize: '0.875em'
                        },
                        pre: {
                            color: '#e5e7eb',
                            backgroundColor: '#1f2937',
                            overflowX: 'auto',
                            fontSize: '0.875em',
                            lineHeight: '1.5',
                            marginTop: '1.25em',
                            marginBottom: '1.25em',
                            borderRadius: '0.375rem',
                            paddingTop: '0.75em',
                            paddingRight: '1em',
                            paddingBottom: '0.75em',
                            paddingLeft: '1em'
                        },
                    }
                }
            }
        }
    },
    plugins: [
        forms,
        require('@tailwindcss/typography'),
    ],
}
