import BackgroundImage from '@/../public/assets/images/sativa.png'
import PublisherImage from '@/../public/assets/images/vendor.png'
import CustomerImage from '@/../public/assets/images/user_icon.png'
import Selections from './Selections'

const RegisterSelection = () => {
  return (
    <section
      className="w-screen h-screen grid place-content-center"
      style={{
        backgroundImage: `url(${BackgroundImage.src})`,
      }}
    >
      <div className="bg-white shadow-md w-auto rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
        <div className="px-3">
          <h3
            style={{
              fontFamily: `Cairo, sans-serif`,
              color: `black`,
              fontWeight: `bolder`,
            }}
            className="mb-30"
          >
            Register As ....
          </h3>
          <div className="flex">
            <Selections
              LinkClass={'mx-11'}
              Name={'register'}
              Linkhref={'publisher'}
              ImageSrc={PublisherImage}
              ImgAlt={'publisher'}
            />

            <Selections
              LinkClass={'mx-11'}
              Name={'register'}
              Linkhref={'customer'}
              ImageSrc={CustomerImage}
              ImgAlt={'customer'}
            />
          </div>
        </div>
      </div>
    </section>
  )
}

export default RegisterSelection
