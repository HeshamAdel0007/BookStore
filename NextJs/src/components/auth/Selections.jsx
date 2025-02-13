import Link from 'next/link'
import Image from 'next/image'

const Selections = ({ Name, LinkClass, Linkhref, ImageSrc, ImgAlt }) => {
  return (
    <Link className={LinkClass} href={`${Name}/${Linkhref}`}>
      <Image src={ImageSrc.src} alt={ImgAlt} width={100} height={100} />
    </Link>
  )
}
// Default props for optional fields
Selections.defaultProps = {
  Name: '',
  LinkClass: '',
  Linkhref: '',
  ImageSrc: '',
  ImgAlt: '',
}

export default Selections
