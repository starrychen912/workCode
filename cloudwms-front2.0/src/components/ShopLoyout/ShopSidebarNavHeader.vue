<template>
    <div class="userlayout-header" :class="{'userlayout-header-padding':!Showvariable}" >
        <a :href="Href" v-if="SiderStatus">
            <div class="userlayout-header-logo" >
                <i class="el-icon-s-shop" v-if="shopinfo.type == 'self'"></i>
                <img src="data:image/png;base64,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" v-if="shopinfo.type == 'amazon'">
                <img v-if="shopinfo.type == 'shopify'" src="data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 25 28'%3e%3cpath fill='%2395BF47' fill-rule='evenodd' d='M17.836 27.059l-.062-23.736c-.16-.16-.472-.112-.594-.076l-.813.252a5.675 5.675 0 00-.39-.957c-.576-1.1-1.42-1.682-2.44-1.683h-.003c-.068 0-.136.006-.204.012h-.008a2.234 2.234 0 00-.092-.105C12.786.29 12.216.059 11.533.079c-1.318.038-2.63.99-3.693 2.679-.75 1.19-1.318 2.683-1.48 3.84L3.767 7.4c-.764.24-.788.263-.888.982C2.803 8.928.806 24.377.806 24.377l16.743 2.895.287-.213zM12.35 1.163a1.347 1.347 0 00-.792-.208c-2.033.06-3.807 3.235-4.26 5.352l1.949-.604.347-.107c.255-1.344.896-2.738 1.733-3.636a3.821 3.821 0 011.023-.797zm-1.793 4.135l2.796-.866c.009-.728-.07-1.805-.435-2.565-.388.16-.715.44-.95.691-.628.675-1.14 1.705-1.41 2.74zM14.23 4.16l1.299-.403c-.208-.674-.7-1.805-1.7-1.994.311.802.391 1.73.4 2.397z' clip-rule='evenodd'/%3e%3cpath fill='%235E8E3E' d='M21.587 5.088c-.099-.008-2.035-.037-2.035-.037s-1.619-1.573-1.778-1.733a.399.399 0 00-.225-.103v24.053l7.256-1.804S21.844 5.447 21.825 5.31a.263.263 0 00-.238-.222z'/%3e%3cpath fill='white' d='M13.528 8.824l-.843 3.153s-.94-.429-2.054-.358c-1.635.103-1.652 1.134-1.636 1.392.09 1.41 3.799 1.718 4.008 5.021.163 2.599-1.379 4.376-3.601 4.516-2.667.169-4.135-1.405-4.135-1.405l.565-2.404s1.478 1.115 2.66 1.04c.773-.048 1.05-.677 1.021-1.121-.116-1.84-3.137-1.731-3.328-4.754-.16-2.544 1.51-5.12 5.196-5.353 1.42-.09 2.147.273 2.147.273'/%3e%3c/svg%3e" class="logo" alt="logo">
            </div>
            <div  class="Htitle" v-if="Showvariable">{{shopinfo.name}}</div>
        </a>
        <a :href="Href" class="userlayout-a" v-else>
            <div class="logimg flex align-center justify-end" :class="{'el-Logo--collapse':!Showvariable,'justify-center':!Showvariable}" >
               <i class="el-icon-s-shop" v-if="shopinfo.type == 'self'"></i>
                 <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAYAAAB5fY51AAAWJklEQVR4nO3dfXBc1XnH8aOX1buM5Egg2xgTCEHmxTatSdOJU9NhKCZQAoSQ2iSTKUlDpiGUCaVD2pC4IS1JGJjhD4Y2LVCSYtIJY9OGQEvaxkkZIGODsDFB5i1gYywjoTdL1tu+dJ61rry2Jfvu7j33nufe72dmBzDW6uzdvb99zrnnnlNhjMkZAFCgkjcJgBYEFgA1CCwAahBYANQgsACoQWABUIPAAqAGgQVADQILgBoEFgA1CCwAahBYANQgsACoQWABUIPAAqAGgQVADQILgBoEFgA1CCwAahBYANQgsACoQWABUIPAAqAGgQVADQILgBoEFgA1CCwAahBYKFnLgoXmiZd3mgNTaZPL5QJ77BoaMRuee8F0nHEmbw6OkuPB41iPG+65L7draCQXtclMJrdld09u2UVreL+S+0j8AeBR8OhctTrX3dufy0YeT/5IiG3s2pGrbWzifUzGI/EHINGPj12zLh9QcTGezuQ2PPdC4t/XuD4qpl8YEmRj1w7zh0vPMC21NbF/0buHR80pJzQ50BIEgUH3hJABcm9w/MoVZycirMTieY3515zOZs36DY860CKUgwor5r6/6Wfmlis+kfTDcJie0TGzoKnBoRbBLyqsmJKgksqCsDpaR2N9/ths2d3jWtNwHFRYMSNzl/a+2p30w1CUpR+/wHQ//UtFLU4uAitGpGpA6SoqKjh6jqNLGAPeDHOUR45hc1s7R9FhBJZibUtOJagCNtz7HsfUYXQJlcrmcoYOjF10Ed1DYClEBRAeQsstdAmVIazCxfF2C4GlxMrLruDkiQjH3R0ElgJfuOMus+Wnm5J+GCJFaLmBMSzHyUJ2a3/vvKQfBmcwphUtKiyH3b/5GcLKMVkqrUhRYTmqc9Vq88r/bU76YXBS39i4aW+oT/phiASB5SjGTNxG1zAadAkdRFi5j/coGgSWYxgj0WPdN76d9EMQOrqEDpEVMb+19lNJPwyq0DUMF4HlELoZ+rSf+kHT9/ZbST8MoSGwHEFY6STvWiVVVmgYw3KA7J4MnYiqcFFhOYDqSjfmZYWHCitib/QPxea1vDkwnF8fXQai53qc/8dXOtDSYLXV18Xp5TiNCiti2quruqZmMzE6UvLPj6czprZK//cmVwvDQYUVIdnYVKOdfQMzFVQ5YSXqqqvyz3PnY09ofitN74ExB1oRf1RYEdJWXW19Z585f3GH1d+hueKkyrKPCisi2q4M5sefLIeV93se+OWz1n8PdKLCioiWSkIGybc+/lgkv1tbtUWFZR8VFuYkJ2BUYSUqq6pUvTmyfhnsosKKwGQmY1KVbn9XuFItDE9MmuaalAMt8Ycqyy4CKwKud3VcO+k0dQ0JLLvoEuIwLp5whAA8BFbItvf0Ots2makOuIwuYchc7t64Xslo6BpSDdpFhYW8ee0nciAC0NzWrv41uIzAQt7+Pne7qp5rb7vdjYYcQ2PrfGfbFgcEVohuuOc+J9ulZWb5hu9804FWHFtXV5fLzVOPMawQ7RoaMYvnNTrXLk3jLoxjJRuBFSJXl1IhsIJFYNlDlzBE/7vzdefapG1Zl4lM1oFWICpUWCGTfQdd+v7VVg1s7NphrlxxtgMtmRsVlj1UWCGrnF74DqVZ3NbGkUswAisis615ftXNt5qpbHhdHtk8AdCELqESLQsWmldee910NAa3O4vGSm/L7h6z8uSTHGjJ3Kig7aHCUmJw77tmQVPDnLvRFDt4zkkFjQismPirKy+dM8xkIbyX9vXlX+gjv+4irKBWNW9d/OWyWbOsIx73uE1mdO40hGBQYQFQg8CCKjVVdAqSjMACoAaBBUANAguAGgQWADUILKjCtIZkI7CgClcJk417CaGKq4sgFuJOAnuosOCUqtTBbekHxifya4fljni4Hlawi3cf1slKEysvu8JMZjJHBdCRj/TkZP6fLbU1Ti10CDcQWAjEum98O99dmy2EBt7dY7b8dJNJVfJxQ3kYwYRvqbo682/PbnV+iWLEF4GFWXWuWm2e/e+n8l0zwBUEFvKeeHmnueSsD3Mw4DQGFRLqlh/8i0lnszPjTIQVNKDCSpD7Nz9jrlv9+0k/DFCMCivm1m94dGY6AWEF7aiwYmrX0IhZPK8x6YcBMUOFFSPNbe0z41KEFeKIwIqBZRetyYfUcO97por72BBjdAmVk6ACkoLAUoqgQhLRJVTm+5t+RlghsaiwFCGokHRUWEoQVgCB5bztPb2EFTCNLqHDZMVNJikAhxBYjqKqAo5Gl9BBhBUwOwLLMYQVMDe6hA4hrA7a9OLL5tktW017e/vMn/X29pprLlljVp58UrSNQ6TYl9ARcR9g3z85ZeYFsNzyG/1D5rTWeYG0yRb2JbSHLqED9o4ciF1YyUlb+AgirETP8P5Angc6EVgRk51oOhrrY/FaVn3m2pmQsoWt6pONdz9ik2Njqts/kcmauuqq0H7fZCYd2u+CewisCGkeZA87qABDlzA6vQf0VlatCxcRVogEFVZE2urr1LV5cGLStNbVOtASJBUVVgQ0dgU/8eUbCStEjgorZLL+ujbMK4IrqLBCtu2pJ1W1l7CCSwisEC0+Z7mq9hJWcA2BFaJdL72opq2EFVxEYOEohBVcRWCFZDydUdHOBR/udKAVwOwIrJDUVuk41D2v7XSgFcDsCKwQVFTqOMx0BeE6AisEY5NTsX+NQBgIrBBo6A5SXUEDAguAGgSWZTfcc5/zbXzk110OtMIfFvBLNtZ0t0zDjc6auoMcz2SjwgKgBoEFQA0CK+GmstmkHwIoQmBZ9IU77nK+jZ/885scaAXgD4PuFmkYIG4/9YOm7+23HGiJPwy6JxsVVsJpCquPXbPOgVYgSlRYFlENBEvLWvhUWPZQYQFQg8CCClWpFG8U6BLaRJcwOJq2RqNLaA8VFhCwjV07OKSWUGFZpKEqOOXcFWb3jm0OtGRuwxOTprlGV5eQKssOAssiDYH10r4+s6yj3YGWzE3jTtkElh0ElkVchi9fOps1VQpPfgLLDsaw4DSNYSWyCqtCDQgsOEtjV9BDfWUHgQWz8rIrnDsIyy5a40ArynP/5mc0N99JjGFZxNyh0mmurgoxlhUsKiw4Z3tPb2zelO7efgdaER9UWBZpqhImMllTV10VeTtk09lsRse2/n5RZQWHwLJIW7fGhRMrLl3BIxFawaBLaFFG2ckXdVjENazEwPiEA63Qj8Cy6KFfPaeuzZdc/9VIfm+cw0q01NY40Ar96BJaxm0lxxf3sCpE17A8VFg4SpgBkqSwEuPpeF1QCBuBhVnZDhKZrJq0sBK1VZVm/YZHHWiJTnQJLZvMZEyqUu/3QnVNjclMTQX6nEkMqiPRNSwNFZZlK9dcqrr96cnJwG7kPTCVJqymcRxKQ2BZtv3n/6n+NVRMn2B7Rw4U/bOdq1bnf1Ye9Q5MTHUJoVU8uoQhiOMHc//klPnJs1vN4//x74f9+WWXf9Jc/pHzTFt9XWRt02TrO/vM+Ys7kn4YfCOwQiCDrN9a+6nYv06UhvEs/wiskFD+Yy4Eln+MYYVEbi4GUB4qrBBRZWE2VFj+UWEBEdrZN8DhLwIVVohku3WZ1wSIwYlJ01pXy7EoAhVWiIKeMY6Dvvjdu9V96z75m1cJqxJQYUWAsazgFI7/aDmuV918q9l09/ccaIk+1Uk/AFGQcYsz21qT98IDduRgtfy366HFAHt56BJGoLN9fuJec9DmOvE3vfiyujajiGNIlzA6dA1Lc7wTX9ackmVcXCHvciVhFQgqrAjxjVs8P8fMhd1/PFLxEVbBocJyAJXW8b05MGxOn39CUT8T9XHlCyl4BJYDUnV1ZnJsLOmHYU51Tc1mYnSkpJ+NKrQIKzvoEjpganycD/gc5LiUGlaideEiyy08Gu+lPQSWQ/igHyI3iwdxPAb3vmvufOyJ4Bp2DEs/fgHvoWV0CR2U9DEtGyf99p5ec+5JbYE/r4egCgcVloPkwy+3mySN3Ftn68Rf1tFudg+PBv68OcIqVFRYjktns6Yq5ieEbOlfHdLOQg0trWZ0oD+Q55Ivlfu/fnMgzwV/CCwFZJWH0bFxpyZDBkHGqaKYM9W25FTT+9Zvy3oOG9uf4fgILEVqG5vM0NCQ+uAqZU6VDaWMFTJrPVqMYSkil/elIpExEznpNZET/drbbs+33YWwMiWMPY2lM4RVxAgspeSklxNOLqW7vF68TCmQdsqJvuE733SgRYfzG1ov7eszDSkWN3FBjkc8Hqm6ulx3b38uKuPpTO6Jl3fm2pacqu54buzaMedRa1mwkHPEnUfiD0CsHysvuyIfIulsNpAYGxifyD/fJdd/NVdRWZn448sj3AeD7gDUYAwLgBoEFgA1CCwAahBYANQgsACoQWABUIPAAqAGgQVADQILgBoEFgA1CCwAahBYANQgsACoQWABUIPAAqAGgQVADQILgBoEFgA1CCwAarBvEZAgJ5/Zbp5bnzYLRgYDfdHpqipTncmYqj+zu0UEm1AAMZX7R2MmU9X5IDEFoVKZtXfKZysP7vO4t6nFDKYazDlX7wn0+QksICb+5CvLzcMrts+8GJvB5JcXYPU3VpvJsamyn4/AApS7896V5i+rt+bDwYWQmkvF9eU/B2NYgFJeUBmzNf8CXA4rUVFRYXK58tpYdIXV93CTeXCwM//vy08cNV+754DZ8fTbZTUCgH87Hl1kzn5/j/MV1WzKrbKKDqx3Hmk1i4YHjn6iAMo9AHPL/sCYCsUDOO83NZm2a0fKeo6iuoSZf6owlbOElZm+ImEILiBwT/1kqbmo/5XEjzabYieO+ik/Jbi88AJQnptvX3kwrFB8YEn15F2mJLgA+y7uHA3l9/x8/tJ8l83v+R2VkqY1SNfQFHFVgm4iUJqpf6401ZnszM8eK1C883Ht9uVmUUfK9+97vmvEbN7Ynf936X7+V3fjYf/vFxd3B/LuBTGGVfI8LJmk9siybb7+rhzkgYbGshsLJJH0VLwrgi23NZnm1vpZj8JnPrvE3HXbVitHSM733z0rZb5W83zJVyYjDSxPfiDe5wvYM6/VrLl3HtMggCLJPYDv7OyN/LBJBXbhYHfJoRX6tIbZFBNaZrrikvuaaq9Ll/urAYTs0ITV4gQxNBTYrTkTD1SbmqniA0jCy/Yd3gCCVcr5HkRgBbYellRL5/5oSf7u8KIakM3lXzxXFAE9vBUgwhboAn4yNvXj1LlFh5aX1DKLXq6KAMBsAk+Hz3+uy7w27yTzqw+cUfTPyi0/cglXgksmzAFAIavLyxReji1W4XyT+X/TaIbeY0oE4IpiL7QFNRfTav9LGikvqpTZs/Jz3qP/70bz4XfCiU1W2glAB+sDRhJachWwnCn/XpIXBpdcWgVQPDl3ZF6XPGRCqCahrjhabBl5LN7s+Tve7LQ2uxeIExkX/vpp3ab1wKH7E+V8LGUGelRdwkiWSA4yuMz0lP8Txg6Y1BezPv42kCxy5X2ovsF8YGT2UPLGmf2GSrFTkIK8lziSJZKlixjkvCvvjZDnlPCS/+aGayRZ4blgMtk5w8oUDLnU1Kd8bRRRzIW0g0NBwRUnkW5CIWs8Z//B8j5mBBcSIr+kU0Vpq5JKsPxr3Yr8tKTjibLCinSWpixIL3efW/0d0+tyyVr0QNzIAHrh2nPlLKG8oG7c19/zewFNJpAHXTA4s82Xt7C+bdy7iDgIehzY+KyEoqyujGv7Esq3xU21L5jKXC6U3UDkG4AVI6CFjZDyVH7Z3xZcfgPLVmHg5Eaq56xaYl76XLhrZhV7pQQIg3e3iLG076AsjfxHn/a/ZrzfwLJVDDi987N8o8i6WaUsW1Mq+XDsbWoxH11f7cSCaUgemdD53Pq0WTAyaK2ikkDZX1tX1PyrYrqD6apKK9OMVGxVX849ieXwwuvktbNvbQYExdsnwVjewVk+0xUy5PKl4n/Wb2DJysK2zhkVgeWx2Yc/Fm+FVDO9FA7dRpRLNkV9t7k1X0WZkLaZlyCRFVFK+fy6UF0ZbYFlptfMslkq+yHltCxgJtXXadeN+JpsB8jEzDcfaDLtY/tDHebwPq/lDIL7vYovv+v077VaG05RF1jigqs6zd+uy5g/eP81B1pjZhYsLPdDgfjxxmFNwUKVYQpq8NtvhWWzujJaA8sj90jtazwhX+a6wruiI9XXYKrBnHO1/bllcINMy1k7/42Zbp4Jqas3myCv0kn31c+EVPns/09LZ1FXHYulOrA8UQ3K+1E4K7j6S2ZmrovcluRn3gvccuT7VjjtwEQYUIVktd8LPv16YJ8vWYLm4RXbj/va5LagUgbzixGLwPIUuyN1FLwPt3QTUul0/g2WkyBVV81YmINkisGeV/vyJ7/c3tU8MX7YBgwufdZkUP2R/tPNLV8Jdrklv91BAqtEpW45FjUJswufPNP0vTdm2k48uLvvpRc2Bf4BxNEe+tF55sFNYzN/Lu9B2JOXy2ErLGQS97bP7/IVzGFcPY9lYHk0B9dh/11RYW7d+zumY/6hP/vTlm62/i+BVEkPDnbO/GBPv8kvaifLrxx53F2u1AvZDAq/1VVYU31iHVhm+oriLy7udqAlwfLG7OTWioUVw4c991n9e6yX5i6TQeLfzF90WAvfzc0zF/W/4uxYZ7HCuonf79xHAitg8s16rEXM4kguMc9FtlPTOAFWvvGP97riLsz3zU8vJcz2JCawCrHL9CGlLvgWNi3ttMF77WF/wRyvuopiqaZEbrMsb7w8vG/qcnb00U5LCCQxrCSofthw3sEryY5Vw1GtK5fICutIctvB82Mnms+OvxiL8Q3o5H1xys3JMgYX5aTjY3UFo1wEk8AqIPd6Pf7DD5kLBw8O0hNesK1wravFd7ebv7hxiRPTWObqDka9Yi+BNQuZe7Lj6bfzV5umqnVOjYDbvKBa/tAp+X/K580Vc1VXLiwvTmD5IIP03h3vVF0oh7dU0V/vWeHsBsCzVVeu7IVAYBVJvn3M9MoMhBf88BaCLHUtqrDJEk6FCwq4tHFLJBupaubdAS/bfl++dMh8dPi3dBlxFK+SOrTkkJ5Va+V+xI+cNGRWDbyefw0ubdRChRUA6TLKjadRLyyIaHnrovXWN7OstiUEVsC8LqOh25gI2rp72hFYFsnVxntvqsmX1gRXPBR29QQrzIaLwAoJVxr18qYgPN36IbP6ajeW5U4qAisi3lyXuKweECfee8Lmuu4hsBwgVxz/ftGLXG2MmK3dihEcAstRrCgRDqonXQgsJWQAX9OSva5xafIjSkdgKSeVWO6I1XGStBTLka/dmGjWjkI4CKyYkhu3+xubZn1x80dHVISarFc2VN8w6/+T17Bu23Lz43u3hd4uRIfASihZA0zWOXeRrFF/w4Zms3lj/NbiR3kILABqJHKJZAA6EVgA1CCwAKhBYAFQg8ACoAaBBUANAguAGgQWADUILABqEFgA1CCwAKhBYAFQg8ACoAaBBUANAguAGgQWADUILABqEFgA1CCwAKhBYAFQg8ACoAaBBUANAguAGgQWADUILABqEFgA1CCwAKhBYAFQg8ACoAaBBUAHY8z/A52T1Rl7s9tFAAAAAElFTkSuQmCC" v-if="shopinfo.type == 'amazon'">
                <img v-if="shopinfo.type == 'shopify'" src="data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 25 28'%3e%3cpath fill='%2395BF47' fill-rule='evenodd' d='M17.836 27.059l-.062-23.736c-.16-.16-.472-.112-.594-.076l-.813.252a5.675 5.675 0 00-.39-.957c-.576-1.1-1.42-1.682-2.44-1.683h-.003c-.068 0-.136.006-.204.012h-.008a2.234 2.234 0 00-.092-.105C12.786.29 12.216.059 11.533.079c-1.318.038-2.63.99-3.693 2.679-.75 1.19-1.318 2.683-1.48 3.84L3.767 7.4c-.764.24-.788.263-.888.982C2.803 8.928.806 24.377.806 24.377l16.743 2.895.287-.213zM12.35 1.163a1.347 1.347 0 00-.792-.208c-2.033.06-3.807 3.235-4.26 5.352l1.949-.604.347-.107c.255-1.344.896-2.738 1.733-3.636a3.821 3.821 0 011.023-.797zm-1.793 4.135l2.796-.866c.009-.728-.07-1.805-.435-2.565-.388.16-.715.44-.95.691-.628.675-1.14 1.705-1.41 2.74zM14.23 4.16l1.299-.403c-.208-.674-.7-1.805-1.7-1.994.311.802.391 1.73.4 2.397z' clip-rule='evenodd'/%3e%3cpath fill='%235E8E3E' d='M21.587 5.088c-.099-.008-2.035-.037-2.035-.037s-1.619-1.573-1.778-1.733a.399.399 0 00-.225-.103v24.053l7.256-1.804S21.844 5.447 21.825 5.31a.263.263 0 00-.238-.222z'/%3e%3cpath fill='white' d='M13.528 8.824l-.843 3.153s-.94-.429-2.054-.358c-1.635.103-1.652 1.134-1.636 1.392.09 1.41 3.799 1.718 4.008 5.021.163 2.599-1.379 4.376-3.601 4.516-2.667.169-4.135-1.405-4.135-1.405l.565-2.404s1.478 1.115 2.66 1.04c.773-.048 1.05-.677 1.021-1.121-.116-1.84-3.137-1.731-3.328-4.754-.16-2.544 1.51-5.12 5.196-5.353 1.42-.09 2.147.273 2.147.273'/%3e%3c/svg%3e" class="logo" alt="logo">
            </div>
            <div  class="Htitle" v-if="Showvariable" >{{shopinfo.name}}</div>
        </a>
    </div>
</template>

<script>
import { defineComponent,onMounted, reactive,toRefs } from 'vue'
import { useRoute } from 'vue-router'
import { getShopInfo } from '../../api/shoplist'
import i18n from '../../locale'
export default defineComponent({
    props:{
        title:{
            type:String,
            default:"町町信息"
        },
        LogoImg:{
            type:String,
            default:"./src/assets/logo.svg"
        },
        Href:{
            type:String,
            default:"/"
        },
        SiderStatus:{
            type:Boolean,
            default:true
        },
        Showvariable:{
            type:Boolean,
            default:true
        }
    },
    setup(){
        const t = i18n.global.t
        const route = useRoute();
        const shop_id = route.query.id
        const data = reactive({
            shopinfo:{
                address1: "广东省",
                id: 4,
                myshopify_domain: "",
                name: "商品1",
                type: "self",
            }
        })
        onMounted(() =>{
            getShopInfo({
                shop_id:shop_id
            }).then(res =>{
                if(res.code === 1){
                    data.shopinfo = res.data
                }
            })
        })
        return {
            t,
            ...toRefs(data)
        }
    }
}
)
</script>

<style lang="scss" scoped>
.el-menu-vertical-demo:not(.el-menu--collapse) {
    width: 200px;
    min-height: 400px;
  }


  .user-layout-wrapper{
      width: 100%;
      height: 60px;
      line-height: 60px;
      
  }
  .userlayout-header{
    width: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 60px !important;
    line-height: 60px !important;
    box-shadow: none !important;
    padding:0px 32px;
    cursor: pointer;
  }
  .userlayout-header-padding{
      padding:0px;
  }
  .userlayout-header a img{
    cursor: pointer;
    max-height: 30px;
    max-width: 30px;
  }
  .userlayout-header a{
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    
  }
  .userlayout-header-logo{
    width:30%;
    display: flex;
    align-items: center;
    justify-content: center;
    // color: var(--el-color-primary);
  }
.userlayout-header a .Htitle{
  font-size: 18px;
  margin: 0 0 0 0;
  font-family: "Chinese Quote", -apple-system, BlinkMacSystemFont, "Segoe UI", "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", "Helvetica Neue", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  font-weight: 600;
  display: inline-block;
  vertical-align: middle;
  color: $menuTextColor;
  animation:mymove 0.5s;
  overflow: hidden;
  text-overflow:ellipsis;
  white-space: nowrap;
}
@keyframes mymove{
    0%{
        opacity: 0;
    }
    50%{
        opacity: 0;
    }
    100%{
        opacity: 1;
    }
}
.Htitle{
    width: 70%;
    transition: all 5s;
}
.logimg{
    width:30%;
}
.userlayout-header .userlayout-a{
width: 100% !important;
}
.userlayout-a h1{
    width: 65%;
    text-align: left;
    margin-left: 20px !important;
}
.el-Logo--collapse{
    width: 100%;
}
.el-icon-s-shop{
    font-size: 30px;
}
</style>