<?php

/**
 * @copyright   : (c) 2022 Copyright by LCode Technologies
 * @developer   : Shivananda Shenoy (Madhukar)
 **/

/** Application Core */
require_once(dirname(__FILE__) . '/app-core/app_auto_load.php');


//API Test
$send_data = array();

//getVkycStatus
// $send_data['METHOD_NAME'] = "getekycSession";
// {"sessionString":"PHPSESSID=7iffnf79kcl7chb8tgr9h4hn25","responseCode":"S"}

// $send_data['METHOD_NAME'] = "getekycCaptcha";
// $send_data['SESSION_STRING'] = "PHPSESSID=qccmfp4fs0cs0j33jibn35e073";
// {"captcha":"\/9j\/4AAQSkZJRgABAgAAAQABAAD\/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL\/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL\/wAARCAAyAK8DASIAAhEBAxEB\/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL\/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6\/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL\/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6\/9oADAMBAAIRAxEAPwD3+iiigAooooAKKKxY\/F2gy+KZfDK6ig1mJN7WrIykjaG+ViNrHaQcAk4z6HABtUUVwd38TIrrT7e+8KaRd+I7Z5ZIZnt45Y\/JdQhwQYyeQ\/6d+ylJRV2B3lFeUXHxh1K0vYrK58FXcN3Njy4JLhld8nAwpiycngY71v8Ah\/xvrmsa3b2F54L1HToJd266mL7Y8KSM5jA5IA696zVaDdk\/zA7iiiitQCiiigArz7xL8YfD\/hbxBdaLfWepyXNts3tBFGUO5AwwS4PRh2r0GvnzWdZsPD\/7S0+qapP5FnBt8yTYzbd1mFHCgnqQOlBrRgpN37HfaD8avCuvavBpqJqFpNcMscLXMA2u7MFVBsZiCSepAHHWvRa+efG9\/ZfFzx3o+k+GLd5UgUrcakIcfumKksQ207I+cbiMs5AHILfQ1A6sFG1tL9AooooMQooooAKKKKACiiigAr5k+IWg6zrnxm8SNoKu19p9vBfKsTFZSEjhH7vHJcFgQBzxxk4B+m68k8P\/APJzPir\/ALBaf+g21BcHa7N\/4YfES08baJHBNLt1u0iUXcT4BlxgecuAAVJ6gD5ScdNpOB+zx\/yIF\/8A9hST\/wBFRVzvxC8M33wx8R2\/jbwajwWcjlby3VMwREkfKwBz5bnt0VgMEEoB0X7PH\/IgX\/8A2FJP\/RUVA2lytor\/ABB\/5LR4W\/7dP\/Shq9jrxz4g\/wDJaPC3\/bp\/6UNXsdYUvil6mZlXnifw\/p129rfa7plrcx43wz3caOuRkZBORwQfxrVr5f8Aitp8t58S\/FE8bIEsoLeeQMTkqVgjwOOuZF9OAa918N+LEvfhna+J7zzpPKsXmuiEUO7xAiQgAgcsjEdOo6V2zpcsVJdQIfHfjm08MaDfyWV\/pkms2\/l7LKaYFzuZc5jDBvusW\/XpXIaR40+KuvaXDqemeGtHns5t3lybtucMVPDTA9Qe1eH6rHeyXEGq38ySzassl6WUYJJlkRsgAAEsjHA4wR9B9M\/CH\/kl2jf9t\/8A0dJWNanyVFFPoaxsoc1upj+EfixLqOuQ+HvE2kvperSMEVsGNCxBYBkc7kJGwAZbcW7ZFcneWVpqP7UL2l9aw3VtJjfDPGHRsWWRlTweQD+FWvj5Etnq3h3VLYvDfFZV89HIYCNkZMc8EF2ORzz7CvY\/7E0n+1f7V\/syy\/tL\/n7+zp533dv38Z+7x16cVnBu7i+hfMoLmS3TPCvHOkXfwr8fWfivQU8rSryXD2sAKIuMGSFiQVCvgsvpg4UbAa910XV7TXtFs9VsX3W11EJEyQSueqtgkBgcgjPBBFP1DS9P1a3W31Kwtb2FW3rHcwrIobBGQGBGcE8+9Gn6Xp+k27W+m2FrZQs29o7aFY1LYAyQoAzgDn2rQidRTir7ot0UUUGQUUUUAFFFFABRRRQAVkW\/hjR7XxNd+I4bPbq13EIZrjzXO9AFAG0naPuL0Hb61r0UARzwQ3VvJb3ESSwyoUkjkUMrqRggg8EEdqzPDvhjR\/CmnyWOiWf2W2klMzJ5rvlyACcsSeij8q16KACiiigDx+10+LVvjz4002dnWG70XyJGjIDBXjt1JGQRnB9K8x0nUNUt9H1P4csqR3WparBBtlAKQuH2yEupznekI\/iGFbHJ5+jrTwfp9n42v\/Fcc1yb+9gEEkbMvlBQEGQNuc\/u17nqaIfBHhy38TnxHDpiR6sWZzOkjgFmUqx2A7ckE5OOSSevNdMa0V9y+9AeGfGLSfsXi\/QNGsUmn8jR7e1gXG6STDyKowByxwOg610vhDxj4p8KeFrPRf8AhXmsXX2bf++2Spu3Oz\/d8o4+9jr2r0PXPAGla\/4t03xHdXF6l5p\/leUkTqI28uQuNwKk9Sc4I4rq656vvNST1tYuM0o8rR4x4f8AC3irxv41svFviy3\/ALMgsvLa3gWPy3cxuSqhGJZV3ZYluTnC8EFfZ6KKiMeUUpOQUUUVRIUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAf\/9k=","responseCode":"S"}

// $send_data['METHOD_NAME'] = "genekycOtp";
// $send_data['SESSION_STRING'] = "PHPSESSID=qccmfp4fs0cs0j33jibn35e073";
// $send_data['CAPTCHA_VALUE'] = "NTMDR";
// $send_data['AADHAAR_NUMBER'] = "461520236646";
//{"errorMessage":"","responseCode":"S"}

//$send_data['METHOD_NAME'] = "validateekycOtp";
//$send_data['SESSION_STRING'] = "PHPSESSID=l8oi9drj5dnergso88ga38t044";
//$send_data['OTP'] = "424242";
//$send_data['AADHAAR_NUMBER'] = "4242424242";
//$send_data['MOBILE_NUMBER'] = "24242424";
//Error: Invalid OTP {"errorMessage":"Invalid OTP","responseCode":"F"}
//{"country":"India","gender":"M","vtc":"Mattu","photo":"\/9j\/4AAQSkZJRgABAgAAAQABAAD\/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL\/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL\/wAARCADIAKADASIAAhEBAxEB\/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL\/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6\/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL\/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6\/9oADAMBAAIRAxEAPwDuwvtThxS0orQzACngUgFOWgBwHFOC+lCin5A68UAN2Z7VFLhBubGAcmuY8Q\/EnQNBdoTci5uQSDFb\/OVx6nOPwzmvPtR+MF\/M7\/YNNhjGPledi7A+owQB9OaLodj2IyIeVOfpSblJ4IJ9Bya8Dm+IXiOYtv1IIvZY4UH64zUEfjXW1+7qc+fUHmldDsfQewkUwx+leJ2XxK8R2o\/4+IroA8idAf1XFdFZfF6FsLqGnSRHoWgcOPrg4P8AOndBZnoxSoypFY+n+MdG1WPda3kb46qflYfUHmtFdStn6SL+dAiWlBxzTBPG44YUuQe9MCcODTuCO1V84pdxx1oAlK46U0nmgSZxSnBNAFqnDgU0GlzzQJj6d34pgNQ3V0lpbvNKyqiKWZmPAFAC3uo2um2kl1dzLFDGNzM3AArw\/wAYfEPUvEjzWmms9ppRypIOHmHufQ\/3fzzUXjDxRP4mvHG8ppkTfu4+nmH+83+ePxJrjp7pXOB8qDoBxUNlJAI0U8t0\/E\/\/AFqk+VMFgiKRxkZJ\/Oq\/nADEYCgd+9SxKGYu7ZPv0qShd4Kko2R6+lRPcMpx8rY9Rmn3LcDEjY7A1SZucZ\/SmA5p3LZzg+1KJ8jk4I\/Wq5OTRQBYS5aNw8bsrDowOCK6TS\/F9zARHdszqOkg+9\/9euTpRnFAHrthrzyxrJDPvU963rTxGwwJRXjGkalJZXS7WOxjhl7V3dvdpJGDnFF2hWPRrfV4pv4qvpKrKCDXm0Vw6HcrGt7TdXOQrk1SkKx12\/kUoaq0MomQMKkqhGmGp4OajAp3QUCHE4Ga8t+K\/iOSC2h0qF9pny0gB5KA8fgTn64r1A8rgjj6Zr5u8e6qdV8ZahMGDRI\/lR46bV4yPr1\/GlLYaRiT3TOvlhjtHX3NV1Uu3Xj3phOeKem8\/KgOc9RWZZNvjiwqYJzySM1d8uI2+8M7zHoBUUGlu4DEkGrsmn3klusauuwDn5jzU88e5fs5djHliZSS7KD\/AHQRn9KfFYzzEEIQD0JFbmnaPHA4klIdvccCtWRFGDkcd6ynWtojWFG+sjnotGUD94c\/jSmxgT\/lmP51sSAEZzVRwMdPzrLnk3ubezijNktYwOFFQmzRuASDV6fGCBVYHBzW0JGNSKKDxPbyAkcg\/nXU6RdJPEWBfK8HLVjTAS25PG4cijRrryLwK33ZPlPsa2MLHZxzkd60LWUs67etYytir1nN5Uqn3oEelaSrfZl3A9KvstZ2jXazWq4POK1uorQgtLTqaFINP6imBT1W6ey0i7ugQGhhaQE9MgZFfK8hyxPevqLxMjN4T1hEUsxsZwoHXOw18ty8OR71Mioje3HetTT7ZyN5yF4puk2YuHLvyi9vetrz7aJthkXI7A5xXPUk9kb04rdj7dNwwtWRbzHuePQUttf2QxlwCfatGC+tZ5VRZBuI4AxXK1K+x2Rce5mxwyFjvVgfWpTAeeSB6VsxwxTrtBBP1qB7Pb8qnpjgiou7miSMpoQchRk1TmgbH3SD6VvJbFJSSeKjukijG6UhR6ngVWpLS3OVkhcE1VZCD0rXnu7Isf3qjn8DWfcXFsOhP5VvBvsc07dGV3B8pscVThYpcIwPRgeK0IWjmyqkEVRnj8qYj8a6UcsjsIpAwHrVmNzkVlQvgKfar8T5xQI7jwze4YITXbKeAa8w0SUpdJivTbRg8CmriSzSIpp4BNSkdqYRzTEDAMjZAbjlTzmvmDxX4fn8O65cWMwbYrExO38aZOD+nPvX05ntg+5riviTpWkaho8c+ozrbzREiFwCS57rwCcfhxSlsNHj2mWzyaTsjO1pHIJ9qvQ6DHGhJYZ9+lT2cCWenJHHMJQGbbIoIDDPXB57VSur64MqRRK7sxwFUZJrjm5c1onXCMeW8iSS08kELIrcdGHSqkaN5gJlAwc8Doakvn1HTWjiuZI4fNjLgl3YcA\/Kdvc4A9OecCqtkL2\/SSVVDLHgkZ5P0qrTtdsV43sjoLO5EMwkY7h2wcVrPdeaxZAMYxXORRSpGshB2McAkVs2LKsbCZye4zXNNu51w20FkvBG218cfe5rB1a7F0+0SbVXoPeo9Su8TMoJwTVO0tRdyM883lRKQM4yzE9Ao7mtKcXuzOpO65SsInaRdrKcHoastp6zffkA+g5NaWoRzaNHB\/onkLOheNnl5wBnkDueKyFvru6EjKhIQZOD2\/Gt\/etdHP7qdmD2QiT90zA+uaivAXaAtje3BqWK8DqQ33qJR5j2xGOGOf51UW9mRNR6GpGcKB6VZjbmqampkPHWrMze064EcynNelaNfrNCoz2rySByGGK7zwsXbGScU4iZ6S3SojT1bNI9aEkRri\/iRY+foltcom6SC4ALf3UYEH82CfpXYk9ap6nZR6jptxZy\/dlQrnGcHqD+BAP4VMo3Viou0kzxUoI0ChRjHIqOS18wKyLgj0qzLEVnKMQCpwavQwgKMDPvXmVJcrPRpx5kZc0dxeWogu4fPRfu7gMj8cZ\/WktrK4tovKA8mDnIzgn8hmuhRURdzvtA7AZNVZcT5CDCep6mn7Wy1K9kmzKuAjbVhUrGvqTyf6U6JCQ27OSOlFyQjbFAwDSwxyOMryccVk25amqSWhgavEEcMe1R6XLDLJtnjDr06kY\/KrmqQMUJPbtWJazeTcYb7pPNdVPWBy1dJnVasZr+32yySTDJbMshc5+rZI\/OsTZPBCYYkVFJ5wOT+Na0M\/ygNyOxqSRBtzwc1PtGivZp6nPC3wSXGWPc1Hcj\/RiB0Vga1LlQvPFZ85H2Zh1LEKPxrem76nPONixZsxtkJ7jNW0bFV4V8uJV9ABUwNamBftTl1B9a9N8MRKLcNxXl1u2HBr0vwvODCF9qqImdyjY71IxyKqhqkD1ZAh60009lJGeKiYMO4\/KmM8m8T2q2PiC4SNSIywdQffnH55H4VVhu1C45BGK2fH8LJrMUhHyPCp3DuQTn+n51y8R6\/MB7152IiuY9DDz902C25hk5FWEjDR8DA71liQrtAOO5Jq39o\/dYzkd+a515nUZ89obmUvuxH2ycVcsjbwMAcOAeRntWLeIv2nzZAJLdOCrthRnt71JbS2U6MtmBC3XjoarkbF7RJkmuz2pkcRrgMeAewrk57M\/M6nnrUupvI8\/7+XAzwq1YOJrNI4ERSBy\/mEk10QXIjmqSU5D9NuxPEIyMOo596vtKAvQ4rNtIEtFPzbnPenNKW9jUOF3oNTaVmJduc4zmqvlmSSIE8Bt5pzuX61NAuS35V0U1ZHPUd2Sg4+lOFAHrS1oYk8JO6vRPCxIUcdq8+t1y6j1Nek+G4tsINVETOz7UoODQVwKQYFWSWEYGh09KjBxUqsCOaAOM8fWfm6XDcYyYpNp+jf8A1wPzrzVSQCM17brdh\/aWj3VqPvvGdn+91H6gV4tICGKshR1OGUjkGuavHqdNCVtBvnBfvZAFZV5rcryFYAFQcAk9auXgbyDtPJGKyV06RCJ\/LDHGCCehrKEI7s2nOWyI5Y7q9HzMTz0Jq9BpV3GgeORGYHlN2Dim20DyXGZjJtPXygAR9M1sy29gsSLG+oRPjlnCsCfoMVpbQhRbdzm7+3aVsllJA7VmYlt2BViPpW9JaxqGLTyM3XATAH+NZVwm35VYsD\/eGP61UexE46jobtioEg\/EVMXLY5qrJZhEV1bORzip4vugUcq6C5pdSVBlgT0FW0GF\/WoY0ycDn1q0FqkrEN3EFPC0oUntUipzTJLemwGWdRjpXqGjW5htVNcP4ftPMnU4716RbR7IlGOMVcUJmwV4qLGGqw4wagfrVEi5qRcVADg1IrZ5oAlIrxrxyUg8XXfljHCFgPUqDz+dex7q8a8aESeL9QyARuQf+OLWdV2ia0leRjGQSRDj86eACm1untVEs0EoVvuHoSelWlbcAQc\/SuSS6o6YvWzJY5EgcMTkVbm1SyDL84XBBxis4xl2KYOcZyelZF8PLkBAGAPzqo67lObitDSvtQtpmxCBux25NZDrvbe3T0qG2IMu4nLdSKsy8nAxirtZmcpuW5E54wO1CkYyTUbkDrTYm8yVV7Z5rSKMWzWtItkW5\/vNz+FWRimD0pwpkjwBmpYgGcL3NQDk1p6ZbebOMChCOx8M2YADYrrwMAVm6PbCG3XjBxWttGK0SEaD81C9PY1GTmmQRmgNg0jEYJJwB1JrJ1HX7HTQ3mzBnVPMKLyQvr+Pb17dKG7DRtB8CvFPEk\/n+J9SkyTi4dfyOP6Vr6v49v76JoLRRaRNwXRsuR7Ht+H51yi\/eyAMVzVZpqyOilFp3ZaNvHdQFHXnHBFY000unT+W5bZ2Jrct24pNQto7mDDjJ7GueM7aPY6JQvqtzF\/tDcODg881Vurvft4G5cEGkudKnt8tG25fXOCKzWMiE545rpiovVHPJyWjLKFcbsgc8Uj3GDxwaqh29TSjkknqappEXY9pC7ZNWrFS1wn1qmBk8VdtJPJbzCCwXnAoQzcxzSjg0iMk0AuIW3R9Cf7p9DSgmmQPjGSOO9db4es9zqcVzllCZJBjmvQNCt\/LjDEVUQZ0UC7IwBU+SKgRuMUpb6VZBLdarZ2svlSTqZ8bhCgLyEeu0ZOPwrFufGECGP7PY392sjFQbODzhx7g7fwySO4FaVtoNlFH5S2sKwlxJ5YQbQw53AdAc96244URDjHC4ApXHYzdBkk1OKe5n068tVUqIxdBQzcZJ2jp2615Ldrc6l4h1WGJx5txeSREsBgoGZVGccY+T0HHNe92aq0EgHaTBwfYV4Tq8K2vjHV7Uqp2XbOQVB4k+buCP4jWNZtI1pJNtHOspxuxgEdKVOgq1ct5zyXA3bZWLjOc88\/p0z7VAFIHFc9zoS6ksT4IzxVvcGXrWaWIqZJCRgE1DNEyVkxkYBrOubWGTIZB+VXWlNVpXHeiLaFJJmTJaQq3C1H9jVlJ5FXX5bpTGyBgcVspMxcUUDbBT1pVG0Yqww5qHqatMho6HwhbmZdRiD4YIrg4zjnGf1Fa7aNqkshgGk21wVUkywTiInn0bPPT1FQeBV\/e6hkknyMAH\/eWujPinSrO\/aKS5MU0D7CHjYBiMBhnGMZrWOqM2rHMxw39lcELY3aSL99Gj3gf8CXI\/lXTaT4tgjAiuoTGw647fUVt31\/o0tlHfR6nZxOy5UtMoz+vNZ8M+na1GYw9vMwHIRg2PyqttiTobW\/t7tA0MquPY1Z3CuKm0U2z77SV4W\/2STTo9Z1WxGJ4xcIP4hyR\/Wi4rF6HSPiTAozr2msg7MmSP\/IX9a07fwbe65HnxPrEuoFeY7WFRDEvqTtxuPocDHPrXRazr2kaFCn9pXsUBccKTlm9woyf0rEX4leEraJpE1OSVlUnyktpAzH0BZQM\/U0D1Ol8M6FYaBbPa6fE0UUzea6mRmzJwCeSccY6eleZfFDTG0vxbb6qEP2a\/jEUpA4Ei9M\/hj8jW9D4\/wBa1GTztI8J3s1qWDxTSMRvHfouASPQmu013Q7Txb4de1uYnRJlDoWXDwv1BwejDv8AiOlTKPMrDi+V3PC9Qm+1GO5eQNJISJGyCxJ5GR14O7knuBjrVZYcrVqTQLjT9Rk0nUh5NyCFWYg7CM8Oe5XIB4BP3hjNZUU02Axz071xzTOym0yWWE5NQAMufSriTb8ZFO8lW5XHNRcuxmmbHeomfOakeLFw0Zq3Fp+5dxxgVSaQtTO2E8gVA4JNbFxCIoDsGWPAqlHAD9481SkS4lJoziolQeZz61pPFg4ABq5oXh6517VEtIFIT700oHEadz9fQf4Gqi76EyVjrvAukldGa4YEG7l4J\/uKSOPxz+Vbeo21veTlJ4I5UJzskQMPyNaeoaBE2iiyhnuLOFFVQbZ9jBR2B\/nXFX+garpU8Mmk6vMxlZiUvGDrnHGOOOM11RVkcrd2adt4V8PNqAnn02NgSDtVmVQf90ED8MVpa74M0We3WSHTbaNRz+5QRn81xXMrrniTT3V9T0HzI1PL2pzkeuAT\/StEfEuJ7f7LZ6JqFxckYEbqF\/luP6UxFOLwPorH5knGf+mpqb\/hDLSFP9FvdQtxnOI7gjNV\/wDhIdZs2H23w1dr5hygjJJx9NuRUv8AwnVvboVvNJ1OFvQwjH6sKBnZ6f8AD7QbNA15CdSu5Tumurti7OfpnA\/n6k1uw+FfD9sY5ItE01JEIZHW1TKkdCDjOaKKBGq5+ZCTweOtXU4+Yc5HzD19xRRQIyde8PQa1bZ3COcAmKZUDFDweh4IyBweuPpjxrXvDlxomoNFc25jR2zG6j5G7kKfbkYPOBnnrRRWVWKcTai7SMg25Q8fjSMAozyDRRXEdhSmjLyh1OD71PEZCNu7AoooAkkUEetUzGwPTFFFMDc0DwpqGvzAQr5VsDh7h1+Vfp\/ePsPxIr1vRtAstGsltbJNq8GSRuWkPqT3oorqpRSVzkrSbdiDUr+zxdRfaYV8pDkGQZzWDr1zZDS7YC6gF0u1kTzBubHoM80UVuYli3Cz2+4dCBjNaVg2JCM8DiiigB2u2+bVbpBh4TuH071C0KyQpPH\/ABDNFFIaP\/\/Z","mobileVerified":true,"house":"4-55","landMark":"","responseCode":"S","careOf":"","dob":"29-12-2000","street":"KOPLA MATTU","district":"Udupi","pinCode":"574105","name":"Nithin","signtureVerified":"false","location":"","refId":"745120220826195533457","state":"Karnataka","mailVerified":false,"postOffice":"Katapadi(udupi)","subDist":"Udupi"}

/*$send_data['METHOD_NAME'] = "validatePan";
$send_data['PAN_NUMBER'] = "AAAPW9785A";*/

// $send_data['METHOD_NAME'] = "nomineeUpdation";
// $send_data['CUSTOMER_CODE'] = "";
// $send_data['DOB'] = "09-03-1998";
// $send_data['RELATION_TO_ACC_HOLDER'] = "";
// $send_data['NOMINEE_ADDRESS'] = "";
// $send_data['GUARDIAN_CUST_CODE'] = "";
// $send_data['GUARDIAN_NAME'] = "";
// $send_data['NATURE_OF_GUARDIAN'] = "";


/*$send_data['METHOD_NAME'] = "virtualCardReq";
$send_data['CARD_TYPE'] = "";
$send_data['SUB_TYPE'] = "";
$send_data['BANK_ID'] = "";
$send_data['BRANCH_ID'] = "";
$send_data['COUNTRY_CODE'] = "";
$send_data['EMB_NAME'] = "";
$send_data['LAST_NAME'] = "";
$send_data['FIRST_NAME'] = "";
$send_data['MID_NAME'] = "";
$send_data['MOBILE_NUMBER'] = "";
$send_data['SMS_ALERT'] = "";
$send_data['DOB'] = "";
$send_data['PAN_NUM'] = "";
$send_data['TAN_NUM'] = "";
$send_data['ADHAR_NUM'] = "";
$send_data['EMAIL_ID'] = "";
$send_data['ACC_NUM'] = "";
$send_data['ACC_TYPE'] = "";
$send_data['ADDRESS1'] = "";
$send_data['ADDRESS2'] = "";
$send_data['ADDRESS3'] = "";
$send_data['CITY'] = "";
$send_data['STATE'] = "";
$send_data['PIN_CODE'] = "";

//$send_data['METHOD_NAME'] = "validateDL";
//$send_data['DL_NO'] = "KA1920220006466";
//$send_data['DOB'] = "09-03-1998";

//$send_data['METHOD_NAME'] = "validateDL";
//$send_data['dlNo'] = "KA1920180000362";
//$send_data['dob'] = "21-06-1992";

//$pid_list = '[{"PID_TYPE":"UID","PID_NUM":"2981922293923939","CARD_NUM":"2981922293923939","DATE_OF_ISSUE":"","PLACE_OF_ISSUE":"","ISSUING_AUTH":"","ISSUING_COUNTRY":"India","EXPIRY_DATE":"","USEDOF_ADDRESS_PF":"1","USEDOF_IDENTITY_CHK":"1"},{"PID_TYPE":"PAN","PID_NUM":"2","CARD_NUM":"KPKPK9898U","DATE_OF_ISSUE":"","PLACE_OF_ISSUE":"","ISSUING_AUTH":"","ISSUING_COUNTRY":"IN","EXPIRY_DATE":"","USEDOF_ADDRESS_PF":"0","USEDOF_IDENTITY_CHK":"1"},{"PID_TYPE":"DL","PID_NUM":"3","CARD_NUM":null,"DATE_OF_ISSUE":"","PLACE_OF_ISSUE":"","ISSUING_AUTH":"","ISSUING_COUNTRY":"IN","EXPIRY_DATE":"","USEDOF_ADDRESS_PF":"0","USEDOF_IDENTITY_CHK":"1"}]';
// $pid_list = '[{"PID_TYPE":"UID","PID_NUM":"2981922293923939","CARD_NUM":"2981922293923939","DATE_OF_ISSUE":"01012021","PLACE_OF_ISSUE":"JALANDHAR","ISSUING_AUTH":"GOI","ISSUING_COUNTRY":"India","EXPIRY_DATE":"01012032","USEDOF_ADDRESS_PF":"1","USEDOF_IDENTITY_CHK":"1"}]';
//     $send_data['METHOD_NAME'] = "createAccount";
//     $send_data['PRODUCT_CODE'] = "205";
//     $send_data['ACC_TYPE'] = "20501";
//     $send_data['ACC_SUB_TYPE'] = "01";
//     $send_data['BRANCH_CODE'] = "13";
//     $send_data['TITLE_CODE'] = "1";
//     $send_data['CONST_CODE'] = "1";
//     $send_data['RELIGION_CODE'] = "6";
//     $send_data['NATIONALITY_CODE'] = "IN";
//     $send_data['WEAKER_SEC_CODE'] = "99";
//     $send_data['CUST_CATCODE'] = "1";
//     $send_data['CUST_SUB_CATCODE'] = "0";
//     $send_data['CUST_SEGMENT_CODE'] = "99999";
//     $send_data['BUSINESS_DIVCODE'] = "99";
//     $send_data['POB_LOC_CODE'] = "881";
//     $send_data['LANGUAGE_CODE'] = "01";
//     $send_data['OCCUPATION_CODE'] = "13";
//     $send_data['COMPANY_CODE'] = "0";
//     $send_data['DESIGN_CODE'] = "0";
//     $send_data['CITY_CODE'] = "310";
//     $send_data['COUNTRY_CODE'] = "IN";
//     $send_data['STATE_CODE'] = "03";
//     $send_data['ANNUAL_INSLAB'] = "2";
//     $send_data['IT_STATUS_CODE'] = "I";
//     $send_data['IT_SUBSTATUS_CODE'] = "0";
//     $send_data['CUST_ARM_CODE'] = "1";
//     $send_data['TYPEOF_CUST'] = "R";
//     $send_data['RISK_CAT'] = "1";
//     $send_data['TYPEOF_ACCOMODATION'] = "1";
//     $send_data['INSUPOLICY_INFO'] = "2";
//     $send_data['CURRENCY_CODE'] = "INR"; 
//     $send_data['ANNUAL_INCOME'] = "100000";
//     $send_data['TAX_TIN_NUMBER'] = "0";
//     $send_data['FIRST_NAME'] = "Harshitha";
//     $send_data['MID_NAME'] = "";
//     $send_data['LAST_NAME'] = "kanniyappan";
//     $send_data['FATHER_NAME'] = "Kanniyappan";
//     $send_data['DOB'] = "24061984";
//     $send_data['GENDER'] = "M";
//     $send_data['UNDER_POVERTY'] = "0";
//     $send_data['RESIDENT_STATUS'] = "R";
//     $send_data['MARITAL_STATUS'] = "M";
//     $send_data['BANK_RELATION'] = "N";
//     $send_data['EMP_NUMBER'] = "";
//     $send_data['COMPANY_NAME'] = "";
//     $send_data['ADDRESS1'] = "P.O BOX 3558";
//     $send_data['ADDRESS2'] = "FLAT NO 744";
//     $send_data['ADDRESS3'] = "KIMARA BARUTI";
//     $send_data['ADDRESS4'] = "DAR ES SALAAM";
//     $send_data['ADDRESS5'] = "TANZANIA";
//     $send_data['POSTBOX_NUM'] = "";
//     $send_data['MOBILE_NUMBER'] = "9841175366";
//     $send_data['EMIAL_ID'] = "hithisissuresh@yahoo.com";
//     $send_data['OFFICE_PHONE_NUM'] = "";
//     $send_data['FAX_NUM'] = "0";
//     $send_data['ALTERNATE_CONTACT_NUM'] = "";
//     $send_data['PERSON_NAME'] = "";
//     $send_data['RESIDENT_NO'] = "";
//     $send_data['OFFICE_NO'] = "";
//     $send_data['EXTENSION_NO'] = "";
//     $send_data['AUTH_CAPITAL'] = "";
//     $send_data['ISSUED_CAPITAL'] = "";
//     $send_data['PAID_UP_CAPITAL'] = "";
//     $send_data['NETWORTH'] = "";
//     $send_data['DATE_OF_INCORP'] = "";
//     $send_data['COUNTRY_OF_INCORP'] = "";
//     $send_data['REGISTRATION_NUM'] = "";
//     $send_data['REGISTRATION_DATE'] = "";
//     $send_data['REGISTRATION_AUTH'] = "";
//     $send_data['YEARS_IN_BUSSINESS'] = "";
//     $send_data['GROSS_TURNOVER'] = "";
//     $send_data['NO_OF_EMP'] = "";
//     $send_data['NO_OF_BRANCH'] = "";
//     $send_data['INDUSTRY_CODE'] = "";
//     $send_data['SUB_INDUSTRY_CODE'] = "";
//     $send_data['PUBLIC_SEC_ENTP'] = "";
//     $send_data['REGISTRATION_EXPIRY_DATE'] = "";
//     $send_data['REGISTRATION_OFFC_ADDRESS'] = "";
//     $send_data['CLIENT_TYPE'] = "I";
//     $send_data['BANK_EMP_CODE'] = "";
//     $send_data['TYPE_OF_EMPLOYMENT'] = "N";
//     $send_data['WORK_FROM_ADTE'] = "";
//     $send_data['CURRENT_ADDRESS'] = "1";
//     $send_data['PERMANENT_ADDRESS'] = "1";
//     $send_data['COMMUNICATION_ADDRESS'] = "0";
//     $send_data['RESIDENT_PHONE_NUM'] = "";
//     $send_data['AADHAAR_REF_NUMBER'] = "";
//     $send_data['CLIENT_REF_NUMBER'] = "745120220826195533457";
//     $send_data['REFER_BY'] = "";
//     $send_data['PID_LIST'] = $pid_list;
 //$send_data['CHANNEL_CODE'] = API_REACH_MB_CHANNEL;
// $send_data['USER_AGENT'] = $browser->getBrowser();


//$send_data['METHOD_NAME'] = "virtualCardReq"; 
//$send_data['CARD_TYPE'] = "T";
//$send_data['SUB_TYPE'] = "04";
//$send_data['BANK_ID'] = "";
//$send_data['BRANCH_ID'] = "";
//$send_data['COUNTRY_CODE'] = "+91";
//$send_data['EMB_NAME'] = "Sameer shinde";
//$send_data['LAST_NAME'] = "shinde";
//$send_data['FIRST_NAME'] = "Sameer";
//$send_data['MID_NAME'] = "Ragav";
//$send_data['SMS_ALERT'] = "Y";
//$send_data['DOB'] = "";
//$send_data['PAN_NUM'] = "";
//$send_data['TAN_NUM'] = "";
//$send_data['ADHAR_NUM'] = "343456763902";
//$send_data['EMAIL_ID'] = "anuradha@gmail.com";
//$send_data['ACC_NUM'] = "323457768902787654";
//$send_data['ACC_TYPE'] = "S";
//$send_data['ADDRESS1'] = "Nashik";
//$send_data['ADDRESS2'] = "";
//$send_data['ADDRESS3'] = "";
//$send_data['ADDRESS3'] = "";
//$send_data['CITY'] = "Pune";
//$send_data['STATE'] = "MAHA";
//$send_data['PIN_CODE'] = "989876";

// $send_data = array();
/*$send_data['METHOD_NAME'] = "notifyUser";
$send_data['MOBILE_NUMBER'] = "8197187971";
$send_data['EMAIL_ID'] = "harshitha.7816@gmail.com";
$send_data['VALUE'] = "123456";
$send_data['SERVICE_CODE'] = "REKYC-OTP-SMS";
$send_data['REQ_TYPE'] = "S"; */

/*
$send_data['METHOD_NAME'] = "linkedPanStatus";
$send_data['PAN_NUMBER'] = "HVHPK2973R";*/

/*$send_data['METHOD_NAME'] = "AcopenFormReq";
$send_data['APP_NUMBER'] = "ARN202312151002901";

/*$item_data['SBREQ_MOBILE_NUM'] = '9988776655';
$item_data['SBREQ_EMAIL_ID'] = 'chandan19891@hotmail.com';
$item_data['SBREQ_APP_NUM'] = 'ARN202308101002101';

$data = array($item_data['SBREQ_MOBILE_NUM'], $item_data['SBREQ_EMAIL_ID'], "");
$smsdata = implode("|", $data);

$send_data = array();
$send_data['METHOD_NAME'] = "smsEmailNotify"; 
$send_data['REQ_TYPE'] =  "S";
$send_data['SERVICE_CODE'] =  "SMS-NEW-AC";
$send_data['REQ_DATA'] =  $smsdata;

$data2 = array($item_data['SBREQ_MOBILE_NUM'], $item_data['SBREQ_EMAIL_ID'], $item_data['SBREQ_APP_NUM']);
$emaildata = implode("|", $data2);

$send_data = array();
$send_data['METHOD_NAME'] = "smsEmailNotify"; 
$send_data['REQ_TYPE'] =  "E";
$send_data['SERVICE_CODE'] =  "EMAIL-AC-DETAILS";
$send_data['REQ_DATA'] =  $emaildata;

$send_data = array();
$send_data['METHOD_NAME'] = "getAadhaarOtp";
$send_data['AADHAAR_NUMBER'] = '461520236646';
$send_data['CHANNEL_CODE'] = API_REACH_MB_CHANNEL;
$send_data['USER_AGENT'] = $browser->getBrowser();*/

/*$send_data = array();
$send_data['METHOD_NAME'] = "dbLinkRespData"; 
$send_data['REQUEST_FOR'] =  "VALCUST";
$send_data['CUSTOMER_ID'] =  "73758";
$send_data['MOBILE_NUMBER'] =  "8558811915";

$send_data = array();
$send_data['METHOD_NAME'] = "dbLinkRespData"; 
$send_data['REQUEST_FOR'] =  "PIDDTLS";
$send_data['CUSTOMER_ID'] =  "73758";
$send_data['MOBILE_NUMBER'] =  "";*/

$send_data['METHOD_NAME'] = "validatePan";
$send_data['PAN_NUMBER'] = "HVHPK2973R";


try {
    $apiConn = new ReachMobApi;
    $output = $apiConn->ReachMobConnect($send_data, "40");
} catch(Exception $e) {
    $ErrorMsg = $e->getMessage(); //Error from Class
}

if(!isset($ErrorMsg) || $ErrorMsg == "") {
    if(!isset($output['responseCode']) || $output['responseCode'] != "S") {
        $ErrorMsg = isset($output['errorMessage']) ? $output['errorMessage'] : "Unexpected API Error";
    }
}

if(isset($ErrorMsg) && $ErrorMsg != "") {
    echo "Error: ".$ErrorMsg."\n \n";
}

echo json_encode($output); 
// echo $output['otpRefNumber'];
//echo $output['responseCode'];