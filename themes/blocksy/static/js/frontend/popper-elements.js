import { loadStyle } from '../helpers'

const mountPopper = (reference) => {
	if (!reference.nextElementSibling) {
		return
	}

	if (reference.nextElementSibling.popperMounted) {
		return
	}

	reference.nextElementSibling.popperMounted = true

	const target = reference.nextElementSibling

	const referenceRect = reference.getBoundingClientRect()
	const targetRect = target.getBoundingClientRect()

	let initialPlacement =
		referenceRect.left > innerWidth / 2 ? 'left' : 'right'

	let placement = initialPlacement

	if (referenceRect.left + targetRect.width > innerWidth) {
		placement = 'left'
	}

	if (referenceRect.left - targetRect.width < 0) {
		placement = 'right'
	}

	if (
		referenceRect.left + targetRect.width > innerWidth &&
		referenceRect.right - targetRect.width < 0
	) {
		placement = initialPlacement

		let offset = 0
		let edgeOffset = 20

		if (placement === 'left') {
			offset = innerWidth - referenceRect.right - edgeOffset
		}

		if (placement === 'right') {
			offset = referenceRect.left - edgeOffset
		}

		offset = Math.round(offset)

		target.style.setProperty(
			'--theme-submenu-inline-offset',
			`${offset * -1}px`
		)
	}

	target.dataset.placement = placement
}

export const mount = (reference) => {
	Promise.all(
		ct_localizations.dynamic_styles_selectors
			.filter(
				(styleDescriptor) =>
					!!reference.closest(styleDescriptor.selector)
			)
			.map(({ url }) => loadStyle(url))
	).then(() => mountPopper(reference))
}
